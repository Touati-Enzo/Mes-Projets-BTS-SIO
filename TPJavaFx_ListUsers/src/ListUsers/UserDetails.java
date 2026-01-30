package ListUsers;

import javafx.beans.property.IntegerProperty;
import javafx.beans.property.SimpleIntegerProperty;
import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;

public class UserDetails {
	private final StringProperty name;
	private final StringProperty email;
	private final StringProperty department;
	private final SimpleIntegerProperty id;

	//Default constructor
	public UserDetails(int id, String name, String email, String department) {
		this.id = new SimpleIntegerProperty(id);
		this.name = new SimpleStringProperty(name);
		this.email = new SimpleStringProperty(email);
		this.department = new SimpleStringProperty(department);
	}

	//Getters
	public String getName() {
		return name.get();
	}

	public String getEmail() {
		return email.get();
	}

	public String getDepartment() {
		return department.get();
	}
	
	public int getId() {
		return id.get();
	}

	//Setters
	public void setName(String value) {
		name.set(value);
	}

	public void setEmail(String value) {
		email.set(value);
	}

	public void setDepartment(String value) {
		department.set(value);
	}
	
	public void setid(int value) {
		id.set(value);
	}

	//Property values
	public StringProperty nameProperty() {
		return name;
	}

	public StringProperty emailProperty() {
		return email;
	}

	public StringProperty departmentProperty() {
		return department;
	}
	
	public IntegerProperty idProperty() {
		return id;
	}
}
