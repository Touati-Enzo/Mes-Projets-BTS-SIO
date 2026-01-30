package Interface;
import java.awt.Color;
import java.awt.EventQueue;
import java.awt.Font;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JPasswordField;
import javax.swing.JTextField;
import javax.swing.border.EmptyBorder;
public class ChangerMdp extends JFrame {
	private static final long serialVersionUID = 1L;
	private JPanel contentPane;
	private JPasswordField passwordField = new JPasswordField();
	private JTextField textField;
	private JLabel lblLogin;
	private JLabel lblEnterNewPassword;
	/**
	 * pour lancer l'application
	 */
	public static void main(String[] args) {
		EventQueue.invokeLater(new Runnable() {
			public void run() {
				try {
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		});
	}
	/**
	 * Create the frame.
	 */
	public ChangerMdp(String nom) {
		setBounds(150, 50, 1024, 400);
		setResizable(false);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		contentPane.setLayout(null);
		passwordField = new JPasswordField();
		passwordField.setFont(new Font("Tahoma", Font.PLAIN, 34));
		passwordField.setBounds(480, 80, 300, 67);
		contentPane.add(passwordField);
		passwordField.setColumns(10);
		JButton btnSearch = new JButton("Valider");
		btnSearch.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				String pstr = passwordField.getText();
				try {
					System.out.println("mettre à jour l'identifiant " + nom);
					System.out.println("mettre à jour le mot de passe");
					Connection con =DriverManager.getConnection("jdbc:mysql://localhost:3306/catalogue", "root", "");
					PreparedStatement st = (PreparedStatement) con.prepareStatement("Update user set mdp=? where nom=?");
					st.setString(1, pstr);
					st.setString(2, nom);
					st.executeUpdate();
					JOptionPane.showMessageDialog(btnSearch, "Le mot de passe est changé avec succès");
				} catch (SQLException sqlException) {
					sqlException.printStackTrace();
				}
			}
		});
		btnSearch.setFont(new Font("Tahoma", Font.PLAIN, 29));
		btnSearch.setBackground(new Color(240, 240, 240));
		btnSearch.setBounds(438, 200, 170, 59);
		contentPane.add(btnSearch);
		lblEnterNewPassword = new JLabel("Entrer le nouveau mot de passe: ");
		lblEnterNewPassword.setFont(new Font("Tahoma", Font.PLAIN, 30));
		lblEnterNewPassword.setBounds(10, 80, 500, 67);
		contentPane.add(lblEnterNewPassword);
	}
}	