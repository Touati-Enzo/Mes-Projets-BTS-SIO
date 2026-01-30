package Interface;

import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import java.awt.BorderLayout;
import javax.swing.JTextArea;
import java.awt.Color;
import javax.swing.JLabel;
import javax.swing.JOptionPane;

import java.awt.Font;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.awt.event.ActionEvent;
import javax.swing.JTextField;
import javax.swing.JPasswordField;
import java.awt.Window.Type;

public class AuthentificationUtilisateur extends JFrame {

	private static final long serialVersionUID = 1L;
	private JPanel contentPane;
	private JTextField textField;
	private JLabel lblNewLabel;
	private JLabel lblPassword;
	private JPasswordField passwordField;
	
	/**
	 * Create the frame.
	 */
	public AuthentificationUtilisateur() {
		setTitle("Page d'Authentification Catalogue");
		setBackground(Color.GRAY);
		setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		setBounds(100, 100, 450, 300);
		contentPane = new JPanel();
		contentPane.setBackground(Color.GRAY);
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		contentPane.setLayout(null);
		
		JLabel lblAuthentification = new JLabel("Authentification");
		lblAuthentification.setFont(new Font("Dialog", Font.BOLD, 20));
		lblAuthentification.setBackground(Color.LIGHT_GRAY);
		lblAuthentification.setBounds(130, 12, 185, 34);
		contentPane.add(lblAuthentification);
		
		JButton btnConnexion = new JButton("Connexion");
		btnConnexion.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				Authentification();
			}
		});
		btnConnexion.setBounds(174, 180, 108, 25);
		contentPane.add(btnConnexion);
		
		textField = new JTextField();
		textField.setBounds(130, 68, 212, 31);
		contentPane.add(textField);
		textField.setColumns(10);
		
		lblNewLabel = new JLabel("Login");
		lblNewLabel.setFont(new Font("Dialog", Font.BOLD, 16));
		lblNewLabel.setBounds(73, 65, 47, 34);
		contentPane.add(lblNewLabel);
		
		lblPassword = new JLabel("Password");
		lblPassword.setFont(new Font("Dialog", Font.BOLD, 16));
		lblPassword.setBounds(34, 108, 87, 34);
		contentPane.add(lblPassword);
		
		passwordField = new JPasswordField();
		passwordField.setBounds(130, 111, 212, 31);
		contentPane.add(passwordField);

	}
	
	private void Authentification() {
		String identifiant = textField.getText().trim();
		String mdp = new String(passwordField.getPassword()).trim();
		
		// Validation des champs
		if(identifiant.isEmpty() || mdp.isEmpty()) {
			JOptionPane.showMessageDialog(this, 
					"Veuillez remplir tout les champs !",
					"Champs manquants", JOptionPane.WARNING_MESSAGE);
			return;
		}

		try {
			Connection connection = (Connection) DriverManager.getConnection("jdbc:mysql://localhost:3306/catalogue", "root", "");
			PreparedStatement st = (PreparedStatement) connection.prepareStatement("Select nom, mdp from user where nom=? and mdp=?");
			st.setString(1, identifiant);
			st.setString(2, mdp);
			ResultSet rs = st.executeQuery();

			if (rs.next()) {
				dispose();
				AccueilUtilisateur ah = new AccueilUtilisateur(identifiant);
				// AccueilUtilisateur ah2 = new  Authentification(identifiant);
				ah.setTitle("Bienvenue");
				ah.setVisible(true);
				JOptionPane.showMessageDialog(this, " Vous vous êtes connecté avec succès");
			} else {
				JOptionPane.showMessageDialog(this, "identifiant et/ou mot de passe erroné(s)");
			}
		} catch (SQLException sqlException) {
			sqlException.printStackTrace();
		}
	}
}
