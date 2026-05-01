package restaurant.model;

public abstract class Employe implements Affichable {
  protected int id;
    protected String nom;

    public Employe(int id, String nom) {
        this.id = id;
        this.nom = nom;
    }
    

    public Employe() {
    }


    public int getId() {
        return id;
    }


    public String getNom() {
        return nom;
    }


    public abstract void travailler();
}
