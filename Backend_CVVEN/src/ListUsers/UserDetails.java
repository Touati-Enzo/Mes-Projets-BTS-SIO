package ListUsers;

import javafx.beans.property.SimpleIntegerProperty;
import javafx.beans.property.SimpleStringProperty;

public class UserDetails {

    private final SimpleIntegerProperty id;
    private final SimpleStringProperty email;
    private final SimpleStringProperty username;
    private final SimpleStringProperty firstName;
    private final SimpleStringProperty lastName;
    private final SimpleStringProperty role;
    private final SimpleStringProperty createdAt;
    private final SimpleStringProperty updatedAt;
    private final SimpleStringProperty phone;
    private final SimpleStringProperty address;
    private final SimpleStringProperty abonnement;

    public UserDetails(int id, String email, String username,
                       String firstName, String lastName, String role,
                       String createdAt, String updatedAt,
                       String phone, String address, String abonnement) {

        this.id = new SimpleIntegerProperty(id);
        this.email = new SimpleStringProperty(email);
        this.username = new SimpleStringProperty(username);
        this.firstName = new SimpleStringProperty(firstName);
        this.lastName = new SimpleStringProperty(lastName);
        this.role = new SimpleStringProperty(role);
        this.createdAt = new SimpleStringProperty(createdAt);
        this.updatedAt = new SimpleStringProperty(updatedAt);
        this.phone = new SimpleStringProperty(phone);
        this.address = new SimpleStringProperty(address);
        this.abonnement = new SimpleStringProperty(abonnement);
    }

    public int getId() { return id.get(); }
    public String getEmail() { return email.get(); }
    public String getUsername() { return username.get(); }
    public String getFirstName() { return firstName.get(); }
    public String getLastName() { return lastName.get(); }
    public String getRole() { return role.get(); }
    public String getCreatedAt() { return createdAt.get(); }
    public String getUpdatedAt() { return updatedAt.get(); }
    public String getPhone() { return phone.get(); }
    public String getAddress() { return address.get(); }
    public String getAbonnement() { return abonnement.get(); }
    
}