package restaurant.model;

public class Cuisinier extends Employe {

    public Cuisinier(int id, String nom) {
        super(id, nom);
    }

    @Override
    public void travailler() {
        System.out.println("Le cuisinier prépare les plats");
    }

    public void preparerPlat() {
        System.out.println("Plat préparé");
    }
}
