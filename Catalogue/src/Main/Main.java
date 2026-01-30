package Main;

import java.awt.EventQueue;

import Interface.AuthentificationUtilisateur;

public class Main {
	public static void main(String[] args) {
		EventQueue.invokeLater(new Runnable() {
			public void run() {
				try {
					AuthentificationUtilisateur frame = new AuthentificationUtilisateur();
					frame.setVisible(true);
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		});
	}
}

