package restaurant.model;

import java.util.ArrayList;
import java.util.Date;

public class Commande {
 private int idCommande;
    private Date date;
    private ArrayList<Plat> plats;

    public Commande(int idCommande) {
        this.idCommande = idCommande;
        this.date = new Date();
        this.plats = new ArrayList<>();
    }
    

    public Commande() {
    }


    public int getIdCommande() {
        return idCommande;
    }


    public void setIdCommande(int idCommande) {
        this.idCommande = idCommande;
    }


    public Date getDate() {
        return date;
    }


    public void setDate(Date date) {
        this.date = date;
    }


    public ArrayList<Plat> getPlats() {
        return plats;
    }


    public void setPlats(ArrayList<Plat> plats) {
        this.plats = plats;
    }


    public void ajouterPlat(Plat p) {
        plats.add(p);
    }

    public void supprimerPlat(Plat p) {
        plats.remove(p);
    }

    public double calculerTotal() {
        double total = 0;
        for (Plat p : plats) {
            total += p.getPrix();
        }
        return total;
    }

    public void afficherCommande() {
        System.out.println("Commande #" + idCommande);
        for (Plat p : plats) {
            p.afficherPlat();
        }
        System.out.println("Total = " + calculerTotal());
    }
}
