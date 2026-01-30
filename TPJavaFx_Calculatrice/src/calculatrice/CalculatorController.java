package calculatrice;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import java.net.URL;
import java.util.ResourceBundle;

public class CalculatorController implements Initializable {

    private Float firstNumber = 0f;
    private int operation = -1;
    private boolean startNewNumber = true;
    
	@FXML
	private Button moins;

	@FXML
	private Button neuf;

	@FXML
	private Button six;

	@FXML
	private Button mult;

	@FXML
	private Button un;

	@FXML
	private TextField resultat;

	@FXML
	private Button effacer;

	@FXML
	private Button sept;

	@FXML
	private Label label;

	@FXML
	private Button deux;

	@FXML
	private Button trois;

	@FXML
	private Button plus;

	@FXML
	private Button huit;

	@FXML
	private Button zero;

	@FXML
	private Button div;

	@FXML
	private Button quatre;

	@FXML
	private Button egale;

	@FXML
	private Button cinq;

	@FXML
	void handleButtonAction(ActionEvent event) {
		if (event.getSource() == un) {
			addDigit("1");
		} else if (event.getSource() == deux) {
			addDigit("2");
		} else if (event.getSource() == trois) {
			addDigit("3");
		} else if (event.getSource() == quatre) {
			addDigit("4");
		} else if (event.getSource() == cinq) {
			addDigit("5");
		} else if (event.getSource() == six) {
			addDigit("6");
		} else if (event.getSource() == sept) {
			addDigit("7");
		} else if (event.getSource() == huit) {
			addDigit("8");
		} else if (event.getSource() == neuf) {
			addDigit("9");
		} else if (event.getSource() == zero) {
			addDigit("0");
		} else if (event.getSource() == effacer) {
			resultat.setText("");
			firstNumber = 0f;
			operation = -1;
			startNewNumber = true;
		} else if (event.getSource() == plus) {
			setOperation(1, "+");
		} else if (event.getSource() == moins) {
			setOperation(2, "-");
		} else if (event.getSource() == mult) {
			setOperation(3, "*");
		} else if (event.getSource() == div) {
			setOperation(4, "/");
		} else if (event.getSource() == egale) {
			calculate();
		}
	}

	private void addDigit(String digit) {
		if (startNewNumber) {
			resultat.setText(digit);
			startNewNumber = false;
		} else {
			resultat.setText(resultat.getText() + digit);
		}
	}

	private void setOperation(int op, String symbol) {
		try {
			firstNumber = Float.parseFloat(resultat.getText());
			operation = op;
			startNewNumber = true;
			// Optionnel : afficher l'opération en cours
			// resultat.setText(resultat.getText() + " " + symbol + " ");
		} catch (NumberFormatException e) {
			resultat.setText("Error");
		}
	}

	private void calculate() {
		if (operation == -1) return; // Aucune opération sélectionnée

		try {
			Float secondNumber = Float.parseFloat(resultat.getText());
			Float result = 0f;

			switch (operation) {
			case 1: // Addition
			result = firstNumber + secondNumber;
			break;
			case 2: // Subtraction
				result = firstNumber - secondNumber;
				break;
			case 3: // Multiplication
				result = firstNumber * secondNumber;
				break;
			case 4: // Division
				if (secondNumber == 0) {
					resultat.setText("Error: Division by zero");
					return;
				}
				result = firstNumber / secondNumber;
				break;
			}

			resultat.setText(String.valueOf(result));
			operation = -1;
			startNewNumber = true;

		} catch (NumberFormatException e) {
			resultat.setText("Error");
		}
	}

	@Override
	public void initialize(URL location, ResourceBundle resources) {
		// Initialisation si nécessaire
	}
}
