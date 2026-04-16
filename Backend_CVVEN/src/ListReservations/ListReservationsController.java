package ListReservations;

import java.net.URL;

import java.sql.*;
import java.util.*;

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

//Imports à ajouter en haut
import javafx.stage.FileChooser;
import java.io.File;
import java.awt.Desktop;

import ListUsers.DbConnection;

public class ListReservationsController implements Initializable {

    @FXML private TableView<ReservationDetails> tableReservations;
    @FXML private TableColumn<ReservationDetails, Integer> colId;
    @FXML private TableColumn<ReservationDetails, Integer> colUserId;
    @FXML private TableColumn<ReservationDetails, String>  colNumChambre;
    @FXML private TableColumn<ReservationDetails, String>  colDateDebut;
    @FXML private TableColumn<ReservationDetails, String>  colDateFin;
    @FXML private TableColumn<ReservationDetails, Integer> colNbPersonne;
    @FXML private TableColumn<ReservationDetails, Double>  colPrix;
    @FXML private TableColumn<ReservationDetails, String>  colStatut;
    @FXML private TableColumn<ReservationDetails, String>  colCreatedAt;
    @FXML private TextField  searchField;
    @FXML private ComboBox<String> filterStatut;

    private final ObservableList<ReservationDetails> data = FXCollections.observableArrayList();
    private FilteredList<ReservationDetails> filteredData;
    private DbConnection dc;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        dc = new DbConnection();

        colId.setCellValueFactory(new PropertyValueFactory<>("id"));
        colUserId.setCellValueFactory(new PropertyValueFactory<>("userId"));
        colNumChambre.setCellValueFactory(new PropertyValueFactory<>("numChambre"));
        colDateDebut.setCellValueFactory(new PropertyValueFactory<>("dateDebut"));
        colDateFin.setCellValueFactory(new PropertyValueFactory<>("dateFin"));
        colNbPersonne.setCellValueFactory(new PropertyValueFactory<>("nbPersonne"));
        colPrix.setCellValueFactory(new PropertyValueFactory<>("prix"));
        colStatut.setCellValueFactory(new PropertyValueFactory<>("statut"));
        colCreatedAt.setCellValueFactory(new PropertyValueFactory<>("createdAt"));

        // Gold price cell
        colPrix.setCellFactory(col -> new TableCell<>() {
            @Override protected void updateItem(Double item, boolean empty) {
                super.updateItem(item, empty);
                setText((empty || item == null) ? null : String.format("%.2f €", item));
                setStyle("-fx-text-fill: #C9A84C; -fx-alignment: CENTER_LEFT;");
            }
        });

        // Status badge cell
        colStatut.setCellFactory(col -> new TableCell<>() {
            @Override protected void updateItem(String item, boolean empty) {
                super.updateItem(item, empty);
                if (empty || item == null) { setText(null); setStyle(""); return; }
                String label, color, bg, border;
                switch (item) {
                    case "confirmee"  -> { label = "✓  Confirmée";  color = "#4CAF50"; bg = "#0F2A1A"; border = "#1E5C30"; }
                    case "annulee"    -> { label = "✕  Annulée";    color = "#E87070"; bg = "#2A0A0A"; border = "#5C1E1E"; }
                    default           -> { label = "⏳  En attente"; color = "#E8C06A"; bg = "#2A1E08"; border = "#5C4A1E"; }
                }
                setText(label);
                setStyle(String.format(
                    "-fx-text-fill: %s; -fx-background-color: %s; " +
                    "-fx-border-color: %s; -fx-border-radius: 10; -fx-background-radius: 10; " +
                    "-fx-padding: 3 10 3 10; -fx-font-size: 8pt; -fx-font-family: Georgia;",
                    color, bg, border));
            }
        });

        // Statut filter
        filterStatut.setItems(FXCollections.observableArrayList("Tous", "en_attente", "confirmee", "annulee"));
        filterStatut.setValue("Tous");

        filteredData = new FilteredList<>(data, p -> true);
        tableReservations.setItems(filteredData);
        loadReservations();
    }

    private void applyFilters() {
        String statut = filterStatut.getValue();
        String search = searchField.getText().toLowerCase().trim();
        filteredData.setPredicate(r -> {
            boolean matchStatut = statut == null || statut.equals("Tous") || r.getStatut().equals(statut);
            boolean matchSearch = search.isEmpty()
                || r.getNumChambre().toLowerCase().contains(search)
                || String.valueOf(r.getUserId()).contains(search);
            return matchStatut && matchSearch;
        });
    }

    @FXML private void applyFilter(ActionEvent e)  { applyFilters(); }
    @FXML private void filterReservations(KeyEvent e) { applyFilters(); }

    private void loadReservations() {
        data.clear();
        String sql = "SELECT id, user_id, num_chambre, date_debut, date_fin, prix, nb_personne, statut, created_at, updated_at FROM reservations ORDER BY date_debut DESC";
        try (Connection conn = dc.Connect();
             PreparedStatement st = conn.prepareStatement(sql);
             ResultSet rs = st.executeQuery()) {
            while (rs.next()) {
                data.add(new ReservationDetails(
                    rs.getInt("id"), rs.getInt("user_id"), rs.getString("num_chambre"),
                    rs.getString("date_debut"), rs.getString("date_fin"),
                    rs.getDouble("prix"), rs.getInt("nb_personne"),
                    rs.getString("statut"), rs.getString("created_at"), rs.getString("updated_at")));
            }
        } catch (SQLException e) { showError("Erreur chargement : " + e.getMessage()); }
    }

    @FXML private void loadDataFromDatabase(ActionEvent e) { loadReservations(); }

    // ── Dialog ─────────────────────────────────────────────────────────────
    private static class ReservationForm {
        int userId, nbPersonne;
        String numChambre, dateDebut, dateFin, statut;
        double prix;
    }

    private Optional<ReservationForm> showReservationDialog(ReservationDetails r) {
        Dialog<ReservationForm> dialog = new Dialog<>();
        dialog.setTitle(r == null ? "Ajouter une réservation" : "Modifier la réservation");
        dialog.setHeaderText(r == null ? "Nouvelle réservation" : "Réservation #" + r.getId());

        ButtonType saveBtnType = new ButtonType("Enregistrer", ButtonData.OK_DONE);
        dialog.getDialogPane().getButtonTypes().addAll(saveBtnType, ButtonType.CANCEL);

        TextField userIdField    = new TextField(r != null ? String.valueOf(r.getUserId())     : "");
        TextField numChambreField= new TextField(r != null ? r.getNumChambre()                 : "");
        TextField dateDebutField = new TextField(r != null ? r.getDateDebut()                  : "");
        TextField dateFinField   = new TextField(r != null ? r.getDateFin()                    : "");
        TextField prixField      = new TextField(r != null ? String.valueOf(r.getPrix())       : "");
        TextField nbPersonneField= new TextField(r != null ? String.valueOf(r.getNbPersonne()) : "");
        ComboBox<String> statutBox = new ComboBox<>(
            FXCollections.observableArrayList("en_attente", "confirmee", "annulee"));
        statutBox.setValue(r != null ? r.getStatut() : "en_attente");
        statutBox.setStyle("-fx-background-color: #070D1A; -fx-border-color: #1E2D45; -fx-border-width:1; -fx-border-radius:4; -fx-text-fill:#B8C8D8; -fx-font-family:Georgia; -fx-font-size:10pt; -fx-pref-width:240;");

        GridPane grid = new GridPane();
        grid.setHgap(12); grid.setVgap(10);
        grid.setPadding(new Insets(20));
        grid.add(new Label("ID Utilisateur *"), 0, 0); grid.add(userIdField,     1, 0);
        grid.add(new Label("N° Chambre *"),     0, 1); grid.add(numChambreField, 1, 1);
        grid.add(new Label("Arrivée *\n(AAAA-MM-JJ)"), 0, 2); grid.add(dateDebutField, 1, 2);
        grid.add(new Label("Départ *\n(AAAA-MM-JJ)"),  0, 3); grid.add(dateFinField,   1, 3);
        grid.add(new Label("Prix total (€) *"), 0, 4); grid.add(prixField,       1, 4);
        grid.add(new Label("Nb personnes *"),   0, 5); grid.add(nbPersonneField, 1, 5);
        grid.add(new Label("Statut"),           0, 6); grid.add(statutBox,       1, 6);

        dialog.getDialogPane().setContent(grid);

        Node saveBtn = dialog.getDialogPane().lookupButton(saveBtnType);
        Runnable validate = () -> saveBtn.setDisable(
            userIdField.getText().trim().isEmpty()     ||
            numChambreField.getText().trim().isEmpty() ||
            dateDebutField.getText().trim().isEmpty()  ||
            dateFinField.getText().trim().isEmpty()    ||
            prixField.getText().trim().isEmpty()       ||
            nbPersonneField.getText().trim().isEmpty());
        validate.run();
        for (TextField tf : new TextField[]{userIdField, numChambreField, dateDebutField, dateFinField, prixField, nbPersonneField})
            tf.textProperty().addListener((o, ov, nv) -> validate.run());

        dialog.setResultConverter(btn -> {
            if (btn != saveBtnType) return null;
            try {
                ReservationForm form = new ReservationForm();
                form.userId     = Integer.parseInt(userIdField.getText().trim());
                form.numChambre = numChambreField.getText().trim();
                form.dateDebut  = dateDebutField.getText().trim();
                form.dateFin    = dateFinField.getText().trim();
                form.prix       = Double.parseDouble(prixField.getText().trim().replace(",", "."));
                form.nbPersonne = Integer.parseInt(nbPersonneField.getText().trim());
                form.statut     = statutBox.getValue();
                return form;
            } catch (NumberFormatException ex) {
                showError("Valeurs numériques invalides.");
                return null;
            }
        });

        return dialog.showAndWait();
    }

    @FXML
    private void addReservation(ActionEvent event) {
        Optional<ReservationForm> result = showReservationDialog(null);
        if (result.isEmpty()) return;
        ReservationForm form = result.get();

        String sql = "INSERT INTO reservations (user_id, num_chambre, date_debut, date_fin, prix, nb_personne, statut, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        try (Connection conn = dc.Connect(); PreparedStatement st = conn.prepareStatement(sql)) {
            st.setInt(1, form.userId); st.setString(2, form.numChambre);
            st.setString(3, form.dateDebut); st.setString(4, form.dateFin);
            st.setDouble(5, form.prix); st.setInt(6, form.nbPersonne);
            st.setString(7, form.statut);
            if (st.executeUpdate() > 0) { loadReservations(); showInfo("Réservation ajoutée."); }
        } catch (SQLException e) { showError("Erreur ajout : " + e.getMessage()); }
    }

    @FXML
    private void editReservation(ActionEvent event) {
        ReservationDetails r = tableReservations.getSelectionModel().getSelectedItem();
        if (r == null) { showError("Sélectionne une réservation à modifier."); return; }

        Optional<ReservationForm> result = showReservationDialog(r);
        if (result.isEmpty()) return;
        ReservationForm form = result.get();

        String sql = "UPDATE reservations SET user_id=?, num_chambre=?, date_debut=?, date_fin=?, prix=?, nb_personne=?, statut=?, updated_at=NOW() WHERE id=?";
        try (Connection conn = dc.Connect(); PreparedStatement st = conn.prepareStatement(sql)) {
            st.setInt(1, form.userId); st.setString(2, form.numChambre);
            st.setString(3, form.dateDebut); st.setString(4, form.dateFin);
            st.setDouble(5, form.prix); st.setInt(6, form.nbPersonne);
            st.setString(7, form.statut); st.setInt(8, r.getId());
            if (st.executeUpdate() > 0) { loadReservations(); showInfo("Réservation modifiée."); }
        } catch (SQLException e) { showError("Erreur modification : " + e.getMessage()); }
    }

    @FXML
    private void deleteReservation(ActionEvent event) {
        ReservationDetails r = tableReservations.getSelectionModel().getSelectedItem();
        if (r == null) { showError("Sélectionne une réservation à supprimer."); return; }
        if (!confirm("Supprimer la réservation #" + r.getId() + " (chambre " + r.getNumChambre() + ") ?")) return;

        String sql = "DELETE FROM reservations WHERE id=?";
        try (Connection conn = dc.Connect(); PreparedStatement st = conn.prepareStatement(sql)) {
            st.setInt(1, r.getId());
            if (st.executeUpdate() > 0) { loadReservations(); showInfo("Réservation supprimée."); }
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
        Optional<ButtonType> res = a.showAndWait();
        return res.isPresent() && res.get() == ButtonType.OK;
    }
 // Méthode à ajouter dans le contrôleur
    @FXML
    private void exportPdf(ActionEvent event) {
        ReservationDetails r = tableReservations.getSelectionModel().getSelectedItem();
        if (r == null) {
            showError("Sélectionne une réservation à exporter.");
            return;
        }

        FileChooser chooser = new FileChooser();
        chooser.setTitle("Enregistrer le PDF");
        chooser.setInitialFileName("reservation_" + r.getId() + ".pdf");
        chooser.getExtensionFilters().add(
            new FileChooser.ExtensionFilter("Fichiers PDF", "*.pdf"));

        File file = chooser.showSaveDialog(tableReservations.getScene().getWindow());
        if (file == null) return;

        try {
            ReservationPdfExporter.export(r, file.getAbsolutePath());

            // ❌ supprimé : ouverture automatique du PDF

            showInfo("PDF exporté avec succès :\n" + file.getAbsolutePath());

        } catch (Exception e) {
            e.printStackTrace();
            showError("Erreur lors de l'export PDF : " + e.getMessage());
        }
    }
}
