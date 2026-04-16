package ListReservations;

import javafx.beans.property.*;

public class ReservationDetails {
    private final IntegerProperty id;
    private final IntegerProperty userId;
    private final StringProperty  numChambre;
    private final StringProperty  dateDebut;
    private final StringProperty  dateFin;
    private final DoubleProperty  prix;
    private final IntegerProperty nbPersonne;
    private final StringProperty  statut;
    private final StringProperty  createdAt;
    private final StringProperty  updatedAt;

    public ReservationDetails(int id, int userId, String numChambre,
                              String dateDebut, String dateFin, double prix,
                              int nbPersonne, String statut,
                              String createdAt, String updatedAt) {
        this.id         = new SimpleIntegerProperty(id);
        this.userId     = new SimpleIntegerProperty(userId);
        this.numChambre = new SimpleStringProperty(numChambre);
        this.dateDebut  = new SimpleStringProperty(dateDebut);
        this.dateFin    = new SimpleStringProperty(dateFin);
        this.prix       = new SimpleDoubleProperty(prix);
        this.nbPersonne = new SimpleIntegerProperty(nbPersonne);
        this.statut     = new SimpleStringProperty(statut);
        this.createdAt  = new SimpleStringProperty(createdAt);
        this.updatedAt  = new SimpleStringProperty(updatedAt);
    }

    public int    getId()         { return id.get(); }
    public int    getUserId()     { return userId.get(); }
    public String getNumChambre() { return numChambre.get(); }
    public String getDateDebut()  { return dateDebut.get(); }
    public String getDateFin()    { return dateFin.get(); }
    public double getPrix()       { return prix.get(); }
    public int    getNbPersonne() { return nbPersonne.get(); }
    public String getStatut()     { return statut.get(); }
    public String getCreatedAt()  { return createdAt.get(); }
    public String getUpdatedAt()  { return updatedAt.get(); }

    public IntegerProperty idProperty()         { return id; }
    public IntegerProperty userIdProperty()     { return userId; }
    public StringProperty  numChambreProperty() { return numChambre; }
    public StringProperty  dateDébutProperty()  { return dateDebut; }
    public StringProperty  dateFinProperty()    { return dateFin; }
    public DoubleProperty  prixProperty()       { return prix; }
    public IntegerProperty nbPersonneProperty() { return nbPersonne; }
    public StringProperty  statutProperty()     { return statut; }
    public StringProperty  createdAtProperty()  { return createdAt; }
    public StringProperty  updatedAtProperty()  { return updatedAt; }
}
