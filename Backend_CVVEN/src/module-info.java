/**
 * 
 */
/**
 * 
 */
module Backend_CVVEN {
    requires javafx.controls;
    requires javafx.fxml;
    requires java.sql;
    requires java.desktop;
    requires pdfbox.app;

    exports Auth;
    exports Dashboard;

    opens Auth;
    opens Dashboard;
    opens ListChambres;
    opens ListReservations;
    opens ListUsers;
}