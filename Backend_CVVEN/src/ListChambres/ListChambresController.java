package ListChambres;

import java.net.URL;
import java.sql.*;
import java.util.Optional;
import java.util.ResourceBundle;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.collections.transformation.FilteredList;
import javafx.event.ActionEvent;
import javafx.fxml.*;
import javafx.geometry.Insets;
import javafx.scene.Node;
import javafx.scene.control.*;
import javafx.scene.control.ButtonBar.ButtonData;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.KeyEvent;
import javafx.scene.layout.GridPane;

import ListUsers.DbConnection;

public class ListChambresController implements Initializable {

    @FXML private TableView<ChambreDetails> tableChambres;
    @FXML private TableColumn<ChambreDetails, Integer> colId;
    @FXML private TableColumn<ChambreDetails, String>  colNumero;
    @FXML private TableColumn<ChambreDetails, Double>  colPrix;
    @FXML private TableColumn<ChambreDetails, Integer> colPersonneMax;
    @FXML private TableColumn<ChambreDetails, String>  colDescription;
    @FXML private TableColumn<ChambreDetails, String>  colDateCreation;
    @FXML private TableColumn<ChambreDetails, String>  colDateModif;
    @FXML private TextField searchField;

    private final ObservableList<ChambreDetails> data = FXCollections.observableArrayList();
    private FilteredList<ChambreDetails> filteredData;
    private DbConnection dc;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        dc = new DbConnection();

        colId.setCellValueFactory(new PropertyValueFactory<>("id"));
        colNumero.setCellValueFactory(new PropertyValueFactory<>("numeroChambre"));
        colPrix.setCellValueFactory(new PropertyValueFactory<>("prixJournalier"));
        colPersonneMax.setCellValueFactory(new PropertyValueFactory<>("personneMax"));
        colDescription.setCellValueFactory(new PropertyValueFactory<>("description"));
        colDateCreation.setCellValueFactory(new PropertyValueFactory<>("dateCreation"));
        colDateModif.setCellValueFactory(new PropertyValueFactory<>("dateModification"));

        // Gold price formatting
        colPrix.setCellFactory(col -> new TableCell<>() {
            @Override protected void updateItem(Double item, boolean empty) {
                super.updateItem(item, empty);
                setText((empty || item == null) ? null : String.format("%.2f €", item));
                setStyle("-fx-text-fill: #C9A84C;");
            }
        });

        filteredData = new FilteredList<>(data, p -> true);
        tableChambres.setItems(filteredData);
        loadChambres();
    }

    @FXML
    private void filterChambres(KeyEvent event) {
        String q = searchField.getText().toLowerCase().trim();
        filteredData.setPredicate(c -> {
            if (q.isEmpty()) return true;
            return c.getNumeroChambre().toLowerCase().contains(q)
                || (c.getDescription() != null && c.getDescription().toLowerCase().contains(q));
        });
    }

    private void loadChambres() {
        data.clear();
        String sql = "SELECT id, numero_chambre, prix_journalier, personne_max, description, date_creation, date_modification FROM chambres ORDER BY numero_chambre";
        try (Connection conn = dc.Connect();
             PreparedStatement st = conn.prepareStatement(sql);
             ResultSet rs = st.executeQuery()) {
            while (rs.next()) {
                data.add(new ChambreDetails(
                    rs.getInt("id"),
                    rs.getString("numero_chambre"),
                    rs.getDouble("prix_journalier"),
                    rs.getInt("personne_max"),
                    rs.getString("description"),
                    rs.getString("date_creation"),
                    rs.getString("date_modification")));
            }
        } catch (SQLException e) { showError("Erreur chargement : " + e.getMessage()); }
    }

    @FXML private void loadDataFromDatabase(ActionEvent e) { loadChambres(); }

    // ── Dialog ─────────────────────────────────────────────────────────────
    private static class ChambreForm {
        String numero, description;
        double prix;
        int personneMax;
    }

    private Optional<ChambreForm> showChambreDialog(ChambreDetails c) {
        Dialog<ChambreForm> dialog = new Dialog<>();
        dialog.setTitle(c == null ? "Ajouter une chambre" : "Modifier la chambre");
        dialog.setHeaderText(c == null ? "Nouvelle chambre" : "Chambre n° " + c.getNumeroChambre());

        ButtonType saveBtnType = new ButtonType("Enregistrer", ButtonData.OK_DONE);
        dialog.getDialogPane().getButtonTypes().addAll(saveBtnType, ButtonType.CANCEL);

        TextField numeroField = new TextField(c != null ? c.getNumeroChambre() : "");
        TextField prixField   = new TextField(c != null ? String.valueOf(c.getPrixJournalier()) : "");
        TextField maxField    = new TextField(c != null ? String.valueOf(c.getPersonneMax()) : "");
        TextArea  descField   = new TextArea(c != null && c.getDescription() != null ? c.getDescription() : "");
        descField.setPrefRowCount(3);
        descField.setWrapText(true);

        GridPane grid = new GridPane();
        grid.setHgap(12); grid.setVgap(10);
        grid.setPadding(new Insets(20));
        grid.add(new Label("N° Chambre *"),    0, 0); grid.add(numeroField, 1, 0);
        grid.add(new Label("Prix / nuit (€) *"), 0, 1); grid.add(prixField, 1, 1);
        grid.add(new Label("Personnes max *"), 0, 2); grid.add(maxField,   1, 2);
        grid.add(new Label("Description"),    0, 3); grid.add(descField,  1, 3);

        dialog.getDialogPane().setContent(grid);

        Node saveBtn = dialog.getDialogPane().lookupButton(saveBtnType);
        Runnable validate = () -> saveBtn.setDisable(
            numeroField.getText().trim().isEmpty() ||
            prixField.getText().trim().isEmpty()   ||
            maxField.getText().trim().isEmpty());
        validate.run();
        numeroField.textProperty().addListener((o,ov,nv) -> validate.run());
        prixField.textProperty().addListener((o,ov,nv)   -> validate.run());
        maxField.textProperty().addListener((o,ov,nv)    -> validate.run());

        dialog.setResultConverter(btn -> {
            if (btn != saveBtnType) return null;
            try {
                ChambreForm form = new ChambreForm();
                form.numero      = numeroField.getText().trim();
                form.prix        = Double.parseDouble(prixField.getText().trim().replace(",", "."));
                form.personneMax = Integer.parseInt(maxField.getText().trim());
                form.description = descField.getText().trim().isEmpty() ? null : descField.getText().trim();
                return form;
            } catch (NumberFormatException ex) {
                showError("Prix et personnes max doivent être des nombres valides.");
                return null;
            }
        });

        return dialog.showAndWait();
    }

    @FXML
    private void addChambre(ActionEvent event) {
        Optional<ChambreForm> result = showChambreDialog(null);
        if (result.isEmpty()) return;
        ChambreForm form = result.get();

        String sql = "INSERT INTO chambres (numero_chambre, prix_journalier, personne_max, description) VALUES (?, ?, ?, ?)";
        try (Connection conn = dc.Connect(); PreparedStatement st = conn.prepareStatement(sql)) {
            st.setString(1, form.numero);
            st.setDouble(2, form.prix);
            st.setInt(3, form.personneMax);
            st.setString(4, form.description);
            if (st.executeUpdate() > 0) { loadChambres(); showInfo("Chambre ajoutée avec succès."); }
        } catch (SQLException e) { showError("Erreur ajout : " + e.getMessage()); }
    }

    @FXML
    private void editChambre(ActionEvent event) {
        ChambreDetails c = tableChambres.getSelectionModel().getSelectedItem();
        if (c == null) { showError("Sélectionne une chambre à modifier."); return; }

        Optional<ChambreForm> result = showChambreDialog(c);
        if (result.isEmpty()) return;
        ChambreForm form = result.get();

        String sql = "UPDATE chambres SET numero_chambre=?, prix_journalier=?, personne_max=?, description=? WHERE id=?";
        try (Connection conn = dc.Connect(); PreparedStatement st = conn.prepareStatement(sql)) {
            st.setString(1, form.numero);
            st.setDouble(2, form.prix);
            st.setInt(3, form.personneMax);
            st.setString(4, form.description);
            st.setInt(5, c.getId());
            if (st.executeUpdate() > 0) { loadChambres(); showInfo("Chambre modifiée avec succès."); }
        } catch (SQLException e) { showError("Erreur modification : " + e.getMessage()); }
    }

    @FXML
    private void deleteChambre(ActionEvent event) {
        ChambreDetails c = tableChambres.getSelectionModel().getSelectedItem();
        if (c == null) { showError("Sélectionne une chambre à supprimer."); return; }
        if (!confirm("Supprimer la chambre n° " + c.getNumeroChambre() + " ?")) return;

        String sql = "DELETE FROM chambres WHERE id=?";
        try (Connection conn = dc.Connect(); PreparedStatement st = conn.prepareStatement(sql)) {
            st.setInt(1, c.getId());
            if (st.executeUpdate() > 0) { loadChambres(); showInfo("Chambre supprimée."); }
        } catch (SQLException e) { showError("Erreur suppression : " + e.getMessage()); }
    }

    private void showInfo(String msg)  {
        Alert a = new Alert(Alert.AlertType.INFORMATION); a.setHeaderText(null); a.setContentText(msg); a.showAndWait();
    }
    private void showError(String msg) {
        Alert a = new Alert(Alert.AlertType.ERROR); a.setHeaderText(null); a.setContentText(msg); a.showAndWait();
    }
    private boolean confirm(String msg) {
        Alert a = new Alert(Alert.AlertType.CONFIRMATION); a.setHeaderText(null); a.setContentText(msg);
        Optional<ButtonType> r = a.showAndWait();
        return r.isPresent() && r.get() == ButtonType.OK;
    }
}
