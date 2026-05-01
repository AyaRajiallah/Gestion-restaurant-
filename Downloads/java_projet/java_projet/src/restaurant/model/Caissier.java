package restaurant.model;

public class Caissier extends Employe {
    public Caissier(int id, String nom) {
        super(id, nom);
    }

    public Caissier() {
    }

    @Override
    public void travailler() {
        System.out.println("Le caissier gere les paiements");
    }

    @Override
    public void afficherDetails() {
        System.out.println("Caissier [id=" + id + ", nom=" + nom + "]");
    }

    public void encaisser(double montant) {
        System.out.println("Paiement de " + montant + " DH effectue");
    }

    public void afficherFacture() {
        System.out.println("Facture imprimee");
    }

    @Override
    public String toString() {
        return "Caissier [id=" + id + ", nom=" + nom + "]";
    }
}
