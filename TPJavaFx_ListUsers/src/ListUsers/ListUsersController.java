package ListUsers;

import java.net.URL;
import java.util.ResourceBundle;
import javafx.fxml.Initializable;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.SQLException;

import javax.swing.JOptionPane;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;

public class ListUsersController implements Initializable {

    @FXML
    private Label label;

    @FXML
    private TableView<UserDetails> tableUser;

    @FXML
    private TableColumn<UserDetails, String> columnName;

    @FXML
    private TableColumn<UserDetails, String> columnEmail;

    @FXML
    private TableColumn<UserDetails, String> columnDepartment;

    @FXML
    private Button btnLoad;

    private ObservableList<UserDetails> data;
    private DbConnection dc;

    @FXML
    private Button btnDeconnection;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        dc = new DbConnection();
        loadDataFromDatabase(null);
    }

    @FXML
    private void loadDataFromDatabase(ActionEvent event) {
        try {
            Connection conn = dc.Connect();
            data = FXCollections.observableArrayList();
            ResultSet rs = conn.createStatement().executeQuery("SELECT * FROM user_info");

            while (rs.next()) {
                data.add(new UserDetails(
                    rs.getInt("id"),
                    rs.getString("name"),
                    rs.getString("email"),
                    rs.getString("department")
                ));
            }

        } catch (SQLException ex) {
            System.err.println("Error: " + ex);
        }

        columnName.setCellValueFactory(new PropertyValueFactory<>("name"));
        columnEmail.setCellValueFactory(new PropertyValueFactory<>("email"));
        columnDepartment.setCellValueFactory(new PropertyValueFactory<>("department"));

        tableUser.setItems(null);
        tableUser.setItems(data);
    }

    @FXML
    private void Deconnection(ActionEvent event) {
        try {
            ((Stage) ((Node) event.getSource()).getScene().getWindow()).close();

            Stage stage = new Stage();
            stage.setScene(new Scene(FXMLLoader.load(getClass().getResource("/Auth/Auth.fxml"))));
            stage.setTitle("Authentification");
            stage.show();

            JOptionPane.showMessageDialog(null, "Déconnexion réussie !");

        } catch (Exception e) {
            JOptionPane.showMessageDialog(null, "Erreur: " + e.getMessage());
        }
    }
}
