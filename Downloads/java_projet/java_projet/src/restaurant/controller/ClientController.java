package restaurant.controller;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import restaurant.dao.ClientDAO;
import restaurant.model.Client;

public class ClientController {
    private final ClientDAO clientDAO;

    public ClientController() {
        this.clientDAO = new ClientDAO();
    }

    public void ajouterClient(Client client) {
        try {
            clientDAO.insert(client);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de l'ajout du client.", e);
        }
    }

    public List<Client> getTousLesClients() {
        try {
            return clientDAO.findAll();
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors du chargement des clients.", e);
        }
    }

    public Client getClientParId(int id) {
        try {
            return clientDAO.findById(id);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la recherche du client.", e);
        }
    }

    public void modifierClient(Client client) {
        try {
            clientDAO.update(client);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la mise a jour du client.", e);
        }
    }

    public void supprimerClient(int id) {
        try {
            clientDAO.delete(id);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la suppression du client.", e);
        }
    }

    public List<Client> rechercherParNom(String motCle) {
        List<Client> resultat = new ArrayList<>();
        String filtre = motCle == null ? "" : motCle.trim().toLowerCase();
        for (Client client : getTousLesClients()) {
            if (client.getNom() != null && client.getNom().toLowerCase().contains(filtre)) {
                resultat.add(client);
            }
        }
        return resultat;
    }
}
