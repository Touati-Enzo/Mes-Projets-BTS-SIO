package ListUsers;

import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Optional;
import java.util.ResourceBundle;
import org.mindrot.jbcrypt.BCrypt;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Insets;
import javafx.scene.Node;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.control.ButtonBar.ButtonData;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.input.KeyEvent;
import javafx.scene.layout.GridPane;
import javafx.stage.Stage;

public class ListUsersController implements Initializable {

    @FXML private TableView<UserDetails> tableUser;
    @FXML private TableColumn<UserDetails, Integer> columnId;
    @FXML private TableColumn<UserDetails, String>  columnEmail;
    @FXML private TableColumn<UserDetails, String>  columnUsername;
    @FXML private TableColumn<UserDetails, String>  columnFirstName;
    @FXML private TableColumn<UserDetails, String>  columnLastName;
    @FXML private TableColumn<UserDetails, String>  columnRole;
    @FXML private TableColumn<UserDetails, String>  columnCreatedAt;
    @FXML private TableColumn<UserDetails, String>  columnUpdatedAt;
    @FXML private TableColumn<UserDetails, String>  columnPhone;
    @FXML private TableColumn<UserDetails, String>  columnAddress;
    @FXML private TableColumn<UserDetails, String> columnAbonnement;
    @FXML private Button btnAdd;
    @FXML private Button btnEdit;
    @FXML private Button btnDelete;
    @FXML private Button btnLoad;
    @FXML private TextField searchField;

    private final ObservableList<UserDetails> data = FXCollections.observableArrayList();
    private FilteredList<UserDetails> filteredData;
    private DbConnection dc;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        dc = new DbConnection();

        columnId.setCellValueFactory(new PropertyValueFactory<>("id"));
        columnEmail.setCellValueFactory(new PropertyValueFactory<>("email"));
        columnUsername.setCellValueFactory(new PropertyValueFactory<>("username"));
        columnFirstName.setCellValueFactory(new PropertyValueFactory<>("firstName"));
        columnLastName.setCellValueFactory(new PropertyValueFactory<>("lastName"));
        columnRole.setCellValueFactory(new PropertyValueFactory<>("role"));
        columnCreatedAt.setCellValueFactory(new PropertyValueFactory<>("createdAt"));
        columnUpdatedAt.setCellValueFactory(new PropertyValueFactory<>("updatedAt"));
        columnPhone.setCellValueFactory(new PropertyValueFactory<>("phone"));
        columnAddress.setCellValueFactory(new PropertyValueFactory<>("address"));
        columnAbonnement.setCellValueFactory(new PropertyValueFactory<>("abonnement"));
        
        filteredData = new FilteredList<>(data, p -> true);

        SortedList<UserDetails> sortedData = new SortedList<>(filteredData);
        sortedData.comparatorProperty().bind(tableUser.comparatorProperty());

        tableUser.setItems(sortedData);
        
     // Coloriser les lignes selon l'abonnement
        tableUser.setRowFactory(tv -> new TableRow<UserDetails>() {
            @Override
            protected void updateItem(UserDetails user, boolean empty) {
                super.updateItem(user, empty);
                getStyleClass().removeAll("row-abonnement-individuel", "row-abonnement-famille");

                if (!empty && user != null && user.getAbonnement() != null) {
                    switch (user.getAbonnement()) {
                        case "Individuel" -> getStyleClass().add("row-abonnement-individuel");
                        case "Famille"    -> getStyleClass().add("row-abonnement-famille");
                    }
                }
            }
        });
        
        loadUsers();
        
        
    }

    @FXML
    private void filterUsers(KeyEvent event) {
        String query = searchField.getText().toLowerCase().trim();
        filteredData.setPredicate(user -> {
            if (query.isEmpty()) return true;
            return user.getEmail().toLowerCase().contains(query)
                || user.getUsername().toLowerCase().contains(query)
                || (user.getFirstName() != null && user.getFirstName().toLowerCase().contains(query))
                || (user.getLastName()  != null && user.getLastName().toLowerCase().contains(query))
                || (user.getPhone()     != null && user.getPhone().toLowerCase().contains(query))
                || (user.getAbonnement() != null && user.getAbonnement().toLowerCase().contains(query));
        });
    }

    private String hashPassword(String plainPassword) {
        return BCrypt.hashpw(plainPassword, BCrypt.gensalt());
    }

    private void showInfo(String msg) {
        Alert alert = new Alert(Alert.AlertType.INFORMATION);
        alert.setTitle("Information");
        alert.setHeaderText(null);
        alert.setContentText(msg);
        alert.showAndWait();
    }

    private void showError(String msg) {
        Alert alert = new Alert(Alert.AlertType.ERROR);
        alert.setTitle("Erreur");
        alert.setHeaderText(null);
        alert.setContentText(msg);
        alert.showAndWait();
    }

    private boolean confirm(String msg) {
        Alert alert = new Alert(Alert.AlertType.CONFIRMATION);
        alert.setTitle("Confirmation");
        alert.setHeaderText(null);
        alert.setContentText(msg);
        Optional<ButtonType> result = alert.showAndWait();
        return result.isPresent() && result.get() == ButtonType.OK;
    }

    private String emptyToNull(String val) {
        return (val == null || val.trim().isEmpty()) ? null : val.trim();
    }

    private boolean isValidUserForm(UserForm form) {
        if (form.email == null || form.email.trim().isEmpty()) {
            showError("L'email est obligatoire.");
            return false;
        }
        if (form.username == null || form.username.trim().isEmpty()) {
            showError("Le username est obligatoire.");
            return false;
        }
        if (!form.email.matches("^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$")) {
            showError("Le format de l'email est invalide.");
            return false;
        }
        return true;
    }

    private void loadUsers() {
        String sql = "SELECT id, email, username, first_name, last_name, role, created_at, updated_at, phone, address, abonnement FROM users";
        data.clear();
        try (Connection conn = dc.Connect();
             PreparedStatement st = conn.prepareStatement(sql);
             ResultSet rs = st.executeQuery()) {
            while (rs.next()) {
                data.add(new UserDetails(
                    rs.getInt("id"), rs.getString("email"), rs.getString("username"),
                    rs.getString("first_name"), rs.getString("last_name"), rs.getString("role"),
                    rs.getString("created_at"), rs.getString("updated_at"),
                    rs.getString("phone"), rs.getString("address"), rs.getString("abonnement")));
            }
        } catch (SQLException e) {
            showError("Erreur lors du chargement des utilisateurs : " + e.getMessage());
        }
    }

    @FXML private void loadDataFromDatabase(ActionEvent event) { loadUsers(); }

    private static class UserForm {
        String email, username, firstName, lastName, role, phone, address, abonnement;
    }

    private Optional<UserForm> showUserDialog(UserDetails user) {
        Dialog<UserForm> dialog = new Dialog<>();
        dialog.setTitle(user == null ? "Ajouter un utilisateur" : "Modifier l'utilisateur");
        dialog.setHeaderText(user == null ? "Nouvel utilisateur" : "Modifier : " + user.getUsername());

        ButtonType saveBtnType = new ButtonType("Enregistrer", ButtonData.OK_DONE);
        dialog.getDialogPane().getButtonTypes().addAll(saveBtnType, ButtonType.CANCEL);

        TextField emailField    = new TextField(user != null ? user.getEmail()     : "");
        TextField usernameField = new TextField(user != null ? user.getUsername()  : "");
        TextField firstNameField = new TextField(user != null ? nvl(user.getFirstName()) : "");
        TextField lastNameField  = new TextField(user != null ? nvl(user.getLastName())  : "");
        TextField phoneField    = new TextField(user != null ? nvl(user.getPhone())   : "");
        TextField addressField  = new TextField(user != null ? nvl(user.getAddress()) : "");
        ComboBox<String> abonnementBox = new ComboBox<>();
        abonnementBox.getItems().addAll("Aucun", "Individuel", "Famille");
        abonnementBox.setValue(user != null ? nvl(user.getAbonnement()) : "Aucun");

        GridPane grid = new GridPane();
        grid.setHgap(12); grid.setVgap(10);
        grid.setPadding(new Insets(20));

        grid.add(new Label("Email *"),    0, 0); grid.add(emailField,    1, 0);
        grid.add(new Label("Username *"), 0, 1); grid.add(usernameField, 1, 1);
        grid.add(new Label("Prénom"),     0, 2); grid.add(firstNameField, 1, 2);
        grid.add(new Label("Nom"),        0, 3); grid.add(lastNameField,  1, 3);
        grid.add(new Label("Téléphone"),  0, 4); grid.add(phoneField,    1, 4);
        grid.add(new Label("Adresse"),    0, 5); grid.add(addressField,  1, 5);
        grid.add(new Label("Abonnement"), 0, 6); grid.add(abonnementBox, 1, 6);

        dialog.getDialogPane().setContent(grid);

        Node saveBtn = dialog.getDialogPane().lookupButton(saveBtnType);
        saveBtn.setDisable(emailField.getText().trim().isEmpty() || usernameField.getText().trim().isEmpty());
        emailField.textProperty().addListener((o, ov, nv) ->
            saveBtn.setDisable(emailField.getText().trim().isEmpty() || usernameField.getText().trim().isEmpty()));
        usernameField.textProperty().addListener((o, ov, nv) ->
            saveBtn.setDisable(emailField.getText().trim().isEmpty() || usernameField.getText().trim().isEmpty()));

        dialog.setResultConverter(btn -> {
            if (btn == saveBtnType) {
                UserForm form = new UserForm();
                form.email     = emailField.getText().trim();
                form.username  = usernameField.getText().trim();
                form.firstName = emptyToNull(firstNameField.getText());
                form.lastName  = emptyToNull(lastNameField.getText());
                form.role      = "user";
                form.phone     = emptyToNull(phoneField.getText());
                form.address   = emptyToNull(addressField.getText());
                form.abonnement = abonnementBox.getValue();
                return form;
            }
            return null;
        });

        return dialog.showAndWait();
    }

    private String nvl(String s) { return s == null ? "" : s; }

    @FXML
    private void addUser(ActionEvent event) {
        Optional<UserForm> result = showUserDialog(null);
        if (result.isEmpty()) return;
        UserForm form = result.get();
        if (!isValidUserForm(form)) return;

        String hashedPassword = hashPassword("password");
        String sql = "INSERT INTO users (email, username, first_name, last_name, role, password, phone, address, abonnement, created_at, updated_at)\n"
        		+ "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        try (Connection conn = dc.Connect(); PreparedStatement st = conn.prepareStatement(sql)) {
            st.setString(1, form.email);
            st.setString(2, form.username);
            st.setString(3, form.firstName);
            st.setString(4, form.lastName);
            st.setString(5, "user");
            st.setString(6, hashedPassword);
            st.setString(7, form.phone);
            st.setString(8, form.address);
            st.setString(9, form.abonnement);
            if (st.executeUpdate() > 0) {
                loadUsers();
                showInfo("Utilisateur ajouté avec succès.\nMot de passe par défaut : password");
            }
        } catch (SQLException e) { showError("Erreur lors de l'ajout : " + e.getMessage()); }
    }

    @FXML
    private void editUser(ActionEvent event) {
        UserDetails user = tableUser.getSelectionModel().getSelectedItem();
        if (user == null) { showError("Sélectionne un utilisateur à modifier."); return; }

        Optional<UserForm> result = showUserDialog(user);
        if (result.isEmpty()) return;
        UserForm form = result.get();
        if (!isValidUserForm(form)) return;

        String sql = "UPDATE users SET email=?, username=?, first_name=?, last_name=?, role=?, phone=?, address=?, abonnement=?, updated_at=NOW() WHERE id=?";
        try (Connection conn = dc.Connect(); PreparedStatement st = conn.prepareStatement(sql)) {
            st.setString(1, form.email); st.setString(2, form.username);
            st.setString(3, form.firstName); st.setString(4, form.lastName);
            st.setString(5, form.role); st.setString(6, form.phone);
            st.setString(7, form.address);
            st.setString(8, form.abonnement);
            st.setInt(9, user.getId());
            if (st.executeUpdate() > 0) { loadUsers(); showInfo("Utilisateur modifié avec succès."); }
        } catch (SQLException e) { showError("Erreur lors de la modification : " + e.getMessage()); }
    }

    @FXML
    private void deleteUser(ActionEvent event) {
        UserDetails user = tableUser.getSelectionModel().getSelectedItem();
        if (user == null) { showError("Sélectionne un utilisateur à supprimer."); return; }
        if (!confirm("Supprimer l'utilisateur « " + user.getUsername() + " » ?")) return;

        String sql = "DELETE FROM users WHERE id=?";
        try (Connection conn = dc.Connect(); PreparedStatement st = conn.prepareStatement(sql)) {
            st.setInt(1, user.getId());
            if (st.executeUpdate() > 0) { loadUsers(); showInfo("Utilisateur supprimé avec succès."); }
        } catch (SQLException e) { showError("Erreur lors de la suppression : " + e.getMessage()); }
    }
}
