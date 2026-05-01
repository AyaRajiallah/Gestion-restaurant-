package restaurant.model;

public class Cuisinier extends Employe {

    public Cuisinier(int id, String nom) {
        super(id, nom);
    }

    @Override
    public void travailler() {
        System.out.println("Le cuisinier prepare les plats");
    }

    @Override
    public void afficherDetails() {
        System.out.println("Cuisinier [id=" + id + ", nom=" + nom + "]");
    }

    public void preparerPlat() {
        System.out.println("Plat prepare");
    }
}
