package ListUsers;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

public class DbConnection {

    public Connection Connect() {
        try {
        	String url = "jdbc:mysql://localhost:3306/ProjetCVVEN?serverTimezone=UTC";
            String user = "user";
            String password = "password";

            Class.forName("com.mysql.jdbc.Driver");
            return DriverManager.getConnection(url, user, password);

        } catch (ClassNotFoundException | SQLException ex) {
            Logger.getLogger(DbConnection.class.getName()).log(Level.SEVERE, null, ex);
            return null;
        }
    }
}