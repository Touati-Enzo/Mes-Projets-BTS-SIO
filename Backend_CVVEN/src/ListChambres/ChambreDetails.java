package ListChambres;

import javafx.beans.property.*;

public class ChambreDetails {
    private final IntegerProperty id;
    private final StringProperty  numeroChambre;
    private final DoubleProperty  prixJournalier;
    private final IntegerProperty personneMax;
    private final StringProperty  description;
    private final StringProperty  dateCreation;
    private final StringProperty  dateModification;

    public ChambreDetails(int id, String numeroChambre, double prixJournalier,
                          int personneMax, String description,
                          String dateCreation, String dateModification) {
        this.id               = new SimpleIntegerProperty(id);
        this.numeroChambre    = new SimpleStringProperty(numeroChambre);
        this.prixJournalier   = new SimpleDoubleProperty(prixJournalier);
        this.personneMax      = new SimpleIntegerProperty(personneMax);
        this.description      = new SimpleStringProperty(description);
        this.dateCreation     = new SimpleStringProperty(dateCreation);
        this.dateModification = new SimpleStringProperty(dateModification);
    }

    public int    getId()               { return id.get(); }
    public String getNumeroChambre()    { return numeroChambre.get(); }
    public double getPrixJournalier()   { return prixJournalier.get(); }
    public int    getPersonneMax()      { return personneMax.get(); }
    public String getDescription()      { return description.get(); }
    public String getDateCreation()     { return dateCreation.get(); }
    public String getDateModification() { return dateModification.get(); }

    public IntegerProperty idProperty()               { return id; }
    public StringProperty  numeroChambreProperty()    { return numeroChambre; }
    public DoubleProperty  prixJournalierProperty()   { return prixJournalier; }
    public IntegerProperty personneMaxProperty()      { return personneMax; }
    public StringProperty  descriptionProperty()      { return description; }
    public StringProperty  dateCreationProperty()     { return dateCreation; }
    public StringProperty  dateModificationProperty() { return dateModification; }
}
