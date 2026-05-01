package restaurant.controller;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import restaurant.dao.EmployeDAO;
import restaurant.model.Employe;

public class EmployeController {
    private final EmployeDAO employeDAO;

    public EmployeController() {
        this.employeDAO = new EmployeDAO();
    }

    public void ajouterEmploye(Employe employe, String role) {
        try {
            employeDAO.insert(employe, role);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de l'ajout de l'employe.", e);
        }
    }

    public List<Employe> getTousLesEmployes() {
        try {
            return employeDAO.findAll();
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors du chargement des employes.", e);
        }
    }

    public List<Employe> getEmployesParRole(String role) {
        try {
            return employeDAO.findByRole(role);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors du filtrage des employes.", e);
        }
    }

    public Employe getEmployeParId(int id) {
        try {
            return employeDAO.findById(id);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la recherche de l'employe.", e);
        }
    }

    public void modifierEmploye(Employe employe, String role) {
        try {
            employeDAO.update(employe, role);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la mise a jour de l'employe.", e);
        }
    }

    public void supprimerEmploye(int id) {
        try {
            employeDAO.delete(id);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la suppression de l'employe.", e);
        }
    }

    public List<Employe> rechercherParNom(String motCle) {
        List<Employe> resultat = new ArrayList<>();
        String filtre = motCle == null ? "" : motCle.trim().toLowerCase();
        for (Employe employe : getTousLesEmployes()) {
            if (employe.getNom() != null && employe.getNom().toLowerCase().contains(filtre)) {
                resultat.add(employe);
            }
        }
        return resultat;
    }
}
