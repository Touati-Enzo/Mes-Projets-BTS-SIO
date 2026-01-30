package Menu;

import java.net.URL;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ResourceBundle;

import javax.swing.JOptionPane;
import javafx.fxml.Initializable;

import ListUsers.DbConnection;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.stage.Stage;
/*
 * 
 * @author Balbal1
 */
public class MenuController implements Initializable {
	
	private DbConnection dc;
	
	@FXML
	private Button btnMenu;
	
	@FXML
	private Button btnDeconnection;
	
	@FXML
	private void AccMenu(ActionEvent event) {
		try { 
            // Fermer fenêtre login
            ((Stage) ((Node) event.getSource()).getScene().getWindow()).close();
            
            // Ouvrir accueil
            Stage stage = new Stage();
            stage.setScene(new Scene(FXMLLoader.load(getClass().getResource("/ListUsers/ListUsers.fxml"))));
            stage.setTitle("Authentification");
            stage.show();
            
	} catch (Exception e) {
        JOptionPane.showMessageDialog(null, "Erreur: " + e.getMessage());
        e.printStackTrace();
	}
	}
	
	@FXML
	private void Deconnection(ActionEvent event) {
		try {
	            
	            // Fermer fenêtre login
	            ((Stage) ((Node) event.getSource()).getScene().getWindow()).close();
	            
	            // Ouvrir accueil
	            Stage stage = new Stage();
	            stage.setScene(new Scene(FXMLLoader.load(getClass().getResource("/Auth/Auth.fxml"))));
	            stage.setTitle("Authentification");
	            stage.show();
	            
	            // Succès - ouvrir l'authentification
	            JOptionPane.showMessageDialog(null, "Déconnexion réussie !");
	            
		} catch (Exception e) {
	        JOptionPane.showMessageDialog(null, "Erreur: " + e.getMessage());
	        e.printStackTrace();
		}
	}
	
	@Override
	public void initialize(URL url, ResourceBundle rb) {
		dc = new DbConnection();
	}
}

