package restaurant.controller;

import java.sql.SQLException;
import java.util.List;

import javax.swing.table.DefaultTableModel;

import restaurant.dao.CommandeDAO;
import restaurant.model.Commande;

public class CommandeController {
    private final CommandeDAO commandeDAO;

    public CommandeController() {
        this.commandeDAO = new CommandeDAO();
    }

    public int creerCommande(int idClient, int numeroTable, int idEmploye) {
        try {
            return commandeDAO.insert(idClient, numeroTable, idEmploye);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la creation de la commande.", e);
        }
    }

    public void ajouterPlatACommande(int idCommande, int idPlat, int quantite) {
        try {
            commandeDAO.ajouterPlat(idCommande, idPlat, quantite);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de l'ajout du plat a la commande.", e);
        }
    }

    public double calculerTotalCommande(int idCommande) {
        try {
            return commandeDAO.calculerTotal(idCommande);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors du calcul du total de la commande.", e);
        }
    }

    public List<Commande> getToutesLesCommandes() {
        try {
            return commandeDAO.findAll();
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors du chargement des commandes.", e);
        }
    }

    public Commande getCommandeParId(int idCommande) {
        try {
            return commandeDAO.findById(idCommande);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la recherche de la commande.", e);
        }
    }

    public void modifierCommande(int idCommande, int idClient, int numeroTable, int idEmploye) {
        try {
            commandeDAO.update(idCommande, idClient, numeroTable, idEmploye);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la mise a jour de la commande.", e);
        }
    }

    public void supprimerCommande(int idCommande) {
        try {
            commandeDAO.delete(idCommande);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la suppression de la commande.", e);
        }
    }

    public void chargerCommandes(DefaultTableModel model) {
        try {
            commandeDAO.afficherCommandes(model);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de l'affichage des commandes.", e);
        }
    }
}
