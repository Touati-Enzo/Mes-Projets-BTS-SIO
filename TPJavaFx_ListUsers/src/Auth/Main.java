package Auth;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

public class Main extends Application {

    @Override
    public void start(Stage auth) throws Exception {
        Parent root =
            FXMLLoader.load(getClass().getResource("/Auth/Auth.fxml"));

        Scene scene = new Scene(root);

        auth.setScene(scene);
        auth.centerOnScreen();
        auth.setTitle("Authentification");
        auth.show();
    }

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        launch(args);
    }
}

