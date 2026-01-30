package Interface;

import java.awt.EventQueue;


import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;
import javax.swing.table.DefaultTableModel;

import Metier.Categorie;
import Metier.IMetier;
import Metier.MetierCatalogueImp;
import Metier.Produit;
import Metier.ProduitModel;
import Metier.SingletonConnection;

import java.awt.BorderLayout;
import java.awt.Color;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JTextField;
import javax.swing.SwingConstants;
import javax.swing.JTable;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;
import java.awt.event.ActionEvent;
import javax.swing.JComboBox;
import java.awt.Window.Type;
import javax.swing.JScrollBar;
import javax.swing.JScrollPane;
import javax.swing.JSeparator;
import javax.swing.table.TableModel;
import java.awt.Component;
import java.awt.FlowLayout;

public class AccueilUtilisateur extends JFrame {

	private static final long serialVersionUID = 1L;
	private JPanel contentPane;
	private JTextField txtSearch;
	private JTextField fieldIdCategorie;
	private MetierCatalogueImp metier=new MetierCatalogueImp();
	private ProduitModel produitModel;
	private JTable topTable;
	
	/**
	 * Create the frame.
	 */
	public AccueilUtilisateur(String userSes) {
		setTitle("AccueilUtilisateur");
		setResizable(false);
		setAlwaysOnTop(true);
		setBackground(Color.GRAY);
		setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		setBounds(100, 100, 756, 486);
		contentPane = new JPanel();
		contentPane.setBackground(Color.GRAY);
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		contentPane.setLayout(new BorderLayout(0, 0));

		JPanel panel = new JPanel();
		contentPane.add(panel, BorderLayout.NORTH);
		panel.setLayout(new FlowLayout(FlowLayout.CENTER, 5, 5));

		JLabel lblMotCl = new JLabel("Mot clé");
		panel.add(lblMotCl);

		txtSearch = new JTextField();
		txtSearch.setToolTipText("");
		panel.add(txtSearch);
		txtSearch.setColumns(12);
		
		
		JButton btnOk = new JButton("OK");
		panel.add(btnOk);

		// ------- Tableau du haut -------
		String[] columnNames = {"idProduit","designationProduit","prix","quantite","idCategorie"};
		DefaultTableModel model = new DefaultTableModel(columnNames, 0);
		topTable = new JTable(model);
		try {
		    Connection conn = SingletonConnection.getConnetion();
		    String query = "SELECT idCategorie FROM categorie ORDER BY idCategorie ASC LIMIT 1";
		    PreparedStatement ps = conn.prepareStatement(query);
		    ResultSet rs = ps.executeQuery();
		    while (rs.next()) {
		        int idCategorie = rs.getInt("idCategorie");
		        
		        List<Produit> produits = metier.getProduitsParIDCategorie(idCategorie);

		        for (Produit p : produits) {
		            model.addRow(new Object[]{
		                p.getIdProduit(),
		                p.getNomProduit(),
		                p.getPrix(),
		                p.getQuantite(),
		                p.getUneCategorie().getIdCategorie()
		            });
		        }
		    }

		} catch (Exception e1) {
		    e1.printStackTrace();
		}
		JScrollPane scrollPane = new JScrollPane(topTable);
		contentPane.add(scrollPane, BorderLayout.CENTER);
		
		// Champs d'affichage de l'idCategorie actuel
		fieldIdCategorie = new JTextField();
		panel.add(fieldIdCategorie);
		fieldIdCategorie.setColumns(2);
		fieldIdCategorie.setText(String.valueOf(fieldIdCategorie));
		try {
		    Connection conn = SingletonConnection.getConnetion();
		    String query = "SELECT idCategorie FROM categorie ORDER BY idCategorie ASC LIMIT 1";
		    PreparedStatement ps = conn.prepareStatement(query);
		    ResultSet rs = ps.executeQuery();
		    if (rs.next()) {     // ← indispensable !
		        int IDCategorie = rs.getInt("idCategorie");
		        fieldIdCategorie.setText(String.valueOf(IDCategorie)); 
		    }

		}	catch (Exception e1) {
		    e1.printStackTrace();
		}
		
		JComboBox comboBox = new JComboBox();
		panel.add(comboBox);
		
		// Charger les catégories dans le JComboBox
		try {
		    List<Categorie> categories = metier.getAllCategorie();
		    for (Categorie c : categories) {
		        comboBox.addItem(c.getNomCategorie());
		    }
		} catch (Exception e) {
		    e.printStackTrace();
		}
		
		//Choisir d'afficher les produits d'une catégorie avec le ComboBox
		comboBox.addActionListener(new ActionListener() {
			@Override
			public void actionPerformed(ActionEvent e) {
				try {
					Connection conn=SingletonConnection.getConnetion();
					produitModel = new ProduitModel();
					String query="Select * from categorie where nomCategorie like ?";
					PreparedStatement ps=conn.prepareStatement(query);
					String nomCat = (String) comboBox.getSelectedItem();
					ps.setString(1, nomCat);
					ResultSet rs = ps.executeQuery();
				    model.setRowCount(0); // vider le tableau
					while (rs.next()) {
						int idCategorie=rs.getInt("idCategorie");
				        fieldIdCategorie.setText(String.valueOf(idCategorie)); 
						List<Produit> produits= metier.getProduitsParIDCategorie(idCategorie);
		                for (Produit p : produits) {
		                    model.addRow(new Object[]{
		                        p.getIdProduit(),
		                        p.getNomProduit(),
		                        p.getPrix(),
		                        p.getQuantite(),
		                        p.getUneCategorie().getIdCategorie()
		                    });
		                } 
					}
				} catch (SQLException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
			}
		});
		
		// Boutton de changement de mot de passe
		JButton btnChangepwd = new JButton("Changer de mdp");
		panel.add(btnChangepwd);
		btnChangepwd.addActionListener(e -> {
			ChangerMdp window = new ChangerMdp(userSes);
			window.setTitle("Changer le mot de passe");
			window.setVisible(true);
		});

		// Boutton de déconnexion
		JButton btnLogout = new JButton("Deconnexion");
		panel.add(btnLogout);
		
		JPanel panel_1 = new JPanel();
		contentPane.add(panel_1, BorderLayout.SOUTH);
		
		JButton btnNewButton_1 = new JButton("New button");
		panel_1.add(btnNewButton_1);
		
		JButton btnNewButton = new JButton("New button");
		panel_1.add(btnNewButton);
		
		JButton btnNewButton_2 = new JButton("New button");
		panel_1.add(btnNewButton_2);
		
		JScrollPane scrollPane_1 = new JScrollPane((Component) null);
		contentPane.add(scrollPane_1, BorderLayout.SOUTH);
		btnLogout.addActionListener(e -> {
			int a = JOptionPane.showConfirmDialog(this, "Êtes-vous sûr ?");
			if(a == JOptionPane.YES_OPTION) {
				dispose();
				AuthentificationUtilisateur login = new AuthentificationUtilisateur();
				login.setTitle("Authentification visiteur");
				login.setVisible(true);
			}
		});
		
		// ------- Action du bouton de recherche -------
		btnOk.addActionListener(e -> {
		    String motcle = txtSearch.getText().trim();
		    model.setRowCount(0); // vider le tableau

		    MetierCatalogueImp metier = new MetierCatalogueImp();
		    List<Produit> resultats = metier.getProduitsParMotCle(motcle);

		    for (Produit p : resultats) {
		        model.addRow(new Object[]{
		            p.getIdProduit(),
		            p.getNomProduit(),
		            p.getPrix(),
		            p.getQuantite(),
		            p.getUneCategorie().getIdCategorie()
		        });
		    }
		});
	}

}
