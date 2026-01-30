package Interface;

import java.awt.BorderLayout;
import java.awt.EventQueue;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollBar;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextField;

import Metier.MetierCatalogueImp;
import Metier.Produit;
import Metier.ProduitModel;
import Metier.SingletonConnection;

public class CatalogueSwing extends JFrame {
	private JLabel jlbMc=new JLabel("Mot clé:");
	private JTextField txtMc=new JTextField(12);
	private JButton btnOk=new JButton("OK");
	private JButton changeMdp=new JButton("Changer de mdp");
	private JButton btnLogout=new JButton("Déconnexion");
	private JTable jtable;
	private ProduitModel produitModel;
	private MetierCatalogueImp metier=new MetierCatalogueImp();
	private JComboBox jcombo=new JComboBox();
	private JTextField txtid=new JTextField(3);
	private void remplirCombo() {
		try {
			Connection conn=SingletonConnection.getConnetion();
			String query="Select * from categorie";
			PreparedStatement ps=conn.prepareStatement(query);
			ResultSet rs=ps.executeQuery();
			while(rs.next()) {
				jcombo.addItem(rs.getString("nomCategorie"));
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

	public CatalogueSwing(String userSes) {
		this.setDefaultCloseOperation(EXIT_ON_CLOSE);
		this.setLayout(new BorderLayout());
		JPanel jPanelN=new JPanel();
		jPanelN.add(jlbMc);jPanelN.add(txtMc);jPanelN.add(btnOk);jPanelN.add(jcombo);jPanelN.add(txtid);
		this.add(jPanelN,BorderLayout.NORTH);
		JPanel jPanelS=new JPanel();
		jPanelS.add(changeMdp);jPanelS.add(btnLogout);
		this.add(jPanelS,BorderLayout.SOUTH);
		produitModel = new ProduitModel();
		jtable=new JTable(produitModel);
		remplirCombo();
		JScrollPane jscrollPane = new JScrollPane(jtable);
		this.add(jscrollPane,BorderLayout.CENTER);
		this.setSize(Toolkit.getDefaultToolkit().getScreenSize());
		this.setVisible(true);

		btnOk.addActionListener(new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent e) {
				String mc= txtMc.getText();
				List<Produit> produits= metier.getProduitsParMotCle(mc);
				produitModel.loadData(produits);
			}
		});
		
		btnLogout.addActionListener(e -> {
			int a = JOptionPane.showConfirmDialog(this, "Êtes-vous sûr ?");
			if(a == JOptionPane.YES_OPTION) {
				dispose();
				AuthentificationUtilisateur login = new AuthentificationUtilisateur();
				login.setTitle("Authentification visiteur");
				login.setVisible(true);
			}
		});
		
		changeMdp.addActionListener(e -> {
			ChangerMdp window = new ChangerMdp(userSes);
			window.setTitle("Changer le mot de passe");
			window.setVisible(true);
		});
		
		jcombo.addActionListener(new ActionListener() {
			
			@Override
			public void actionPerformed(ActionEvent e) {
				try {
					Connection conn=SingletonConnection.getConnetion();
					String query="Select * from categorie where nomCategorie like ?";
					PreparedStatement ps=conn.prepareStatement(query);
					String nomCat = (String) jcombo.getSelectedItem();
					ps.setString(1, nomCat);
					ResultSet rs = ps.executeQuery();
					while (rs.next()) {
						int idCategorie=rs.getInt("idCategorie");
						List<Produit> produits= metier.getProduitsParIDCategorie(idCategorie);
						produitModel.loadData(produits);
						txtid.setText(String.valueOf(rs.getInt("idCategorie")));
						txtid.setEditable(false);
					}
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
			}
		});

	}
	/*
	public static void main(String[] args) {
		new CatalogueSwing();
	}
	*/
}







