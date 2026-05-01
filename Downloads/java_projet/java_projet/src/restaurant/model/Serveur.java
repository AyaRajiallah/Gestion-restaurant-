package restaurant.model;

public class Serveur extends Employe {
    public Serveur(int id, String nom) {
        super(id, nom);
    }

    @Override
    public void travailler() {
        System.out.println("Le serveur prend les commandes");
    }

    @Override
    public void afficherDetails() {
        System.out.println("Serveur [id=" + id + ", nom=" + nom + "]");
    }

    public void prendreCommande() {
        System.out.println("Commande prise");
    }
}
