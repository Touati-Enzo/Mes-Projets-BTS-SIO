package Metier;

import java.sql.Connection;
import java.sql.DriverManager;

public class SingletonConnection {
private static Connection connection;
   static {
	    try {
			Class.forName("com.mysql.jdbc.Driver");
			connection=DriverManager.getConnection("jdbc:mysql://localhost/catalogue", "root", "");
			System.out.println("Création d'une connexion");
			
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
   }
   public static Connection getConnetion() {
	   return connection;
   }
   
}
