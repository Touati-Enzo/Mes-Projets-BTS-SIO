package Dashboard;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.layout.StackPane;
import javafx.stage.Stage;

public class DashboardController implements Initializable {

    @FXML private StackPane contentArea;
    @FXML private Button navUsers;
    @FXML private Button navChambres;
    @FXML private Button navReservations;

    private Button activeNav;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        loadView("/ListUsers/ListUsers.fxml");
        activeNav = navUsers;
    }

    private void setActive(Button btn) {
        if (activeNav != null) {
            activeNav.getStyleClass().removeAll("nav-btn-active");
            if (!activeNav.getStyleClass().contains("nav-btn"))
                activeNav.getStyleClass().add("nav-btn");
        }
        btn.getStyleClass().remove("nav-btn");
        if (!btn.getStyleClass().contains("nav-btn-active"))
            btn.getStyleClass().add("nav-btn-active");
        activeNav = btn;
    }

    private void loadView(String fxmlPath) {
        try {
            Parent view = FXMLLoader.load(getClass().getResource(fxmlPath));
            contentArea.getChildren().setAll(view);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    @FXML
    private void showUsers(ActionEvent event) {
        setActive(navUsers);
        loadView("/ListUsers/ListUsers.fxml");
    }

    @FXML
    private void showChambres(ActionEvent event) {
        setActive(navChambres);
        loadView("/ListChambres/ListChambres.fxml");
    }

    @FXML
    private void showReservations(ActionEvent event) {
        setActive(navReservations);
        loadView("/ListReservations/ListReservations.fxml");
    }

    @FXML
    private void logout(ActionEvent event) {
        try {
            Stage currentStage = (Stage) contentArea.getScene().getWindow();
            currentStage.close();

            FXMLLoader loader = new FXMLLoader(getClass().getResource("/Auth/Auth.fxml"));
            Stage stage = new Stage();
            stage.setScene(new Scene(loader.load()));
            stage.setTitle("Authentification — Hôtel Prestige");
            stage.show();
        } catch (Exception e) {
            Alert alert = new Alert(Alert.AlertType.ERROR);
            alert.setContentText("Erreur lors de la déconnexion : " + e.getMessage());
            alert.showAndWait();
        }
    }
}
