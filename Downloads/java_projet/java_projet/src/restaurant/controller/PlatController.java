package restaurant.controller;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import restaurant.dao.PlatDAO;
import restaurant.model.Plat;

public class PlatController {
    private final PlatDAO platDAO;

    public PlatController() {
        this.platDAO = new PlatDAO();
    }

    public void ajouterPlat(Plat plat) {
        try {
            platDAO.insert(plat);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de l'ajout du plat.", e);
        }
    }

    public List<Plat> getTousLesPlats() {
        try {
            return platDAO.findAll();
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors du chargement des plats.", e);
        }
    }

    public List<Plat> getPlatsParCategorie(String categorie) {
        try {
            return platDAO.findByCategorie(categorie);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors du filtrage des plats.", e);
        }
    }

    public Plat getPlatParId(int id) {
        try {
            return platDAO.findById(id);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la recherche du plat.", e);
        }
    }

    public void modifierPlat(Plat plat) {
        try {
            platDAO.update(plat);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la mise a jour du plat.", e);
        }
    }

    public void supprimerPlat(int id) {
        try {
            platDAO.delete(id);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la suppression du plat.", e);
        }
    }

    public List<Plat> rechercherParNom(String motCle) {
        List<Plat> resultat = new ArrayList<>();
        String filtre = motCle == null ? "" : motCle.trim().toLowerCase();
        for (Plat plat : getTousLesPlats()) {
            if (plat.getNom() != null && plat.getNom().toLowerCase().contains(filtre)) {
                resultat.add(plat);
            }
        }
        return resultat;
    }
}
