package Auth;

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
public class AuthController implements Initializable {
	
	private DbConnection dc;
	
	@FXML
	private Button btnConnexion;
	
	@FXML 
	private TextField loginField;
	
	@FXML 
	private TextField pswdField;
	
	@FXML
	private void Authentification(ActionEvent event) {
		Connection conn = dc.Connect();
		String login = loginField.getText();
		String pswd = pswdField.getText();
		
	    // Validation simple
	    if (login.isEmpty() || pswd.isEmpty()) {
	        JOptionPane.showMessageDialog(null, "Veuillez remplir tous les champs");
	        return;
	    }
	    
		PreparedStatement st;
		
		try {
			st = (PreparedStatement) conn.prepareStatement("Select login, password from auth where login=? and password=?");
			st.setString(1, login);
			st.setString(2, pswd);
			
			ResultSet rs = st.executeQuery();
			
			if (rs.next()) {
	            
	            // Fermer fenêtre login
	            ((Stage) ((Node) event.getSource()).getScene().getWindow()).close();
	            
	            // Ouvrir accueil
	            Stage stage = new Stage();
	            stage.setScene(new Scene(FXMLLoader.load(getClass().getResource("/Menu/Menu.fxml"))));
	            stage.setTitle("Menu Principal");
	            stage.show();
	            
	            // Succès - ouvrir l'accueil
	            JOptionPane.showMessageDialog(null, "Connexion réussie !");
	            
			} else {
				JOptionPane.showMessageDialog(null, "Identifiant/mot de passe incorrect");
			}
			
			conn.close();
			
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
