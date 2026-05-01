package restaurant.controller;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import restaurant.dao.TableRestoDAO;
import restaurant.model.TableResto;

public class TableRestoController {
    private final TableRestoDAO tableRestoDAO;

    public TableRestoController() {
        this.tableRestoDAO = new TableRestoDAO();
    }

    public void ajouterTable(TableResto table) {
        try {
            tableRestoDAO.insert(table);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de l'ajout de la table.", e);
        }
    }

    public List<TableResto> getToutesLesTables() {
        try {
            return tableRestoDAO.findAll();
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors du chargement des tables.", e);
        }
    }

    public List<TableResto> getTablesLibres() {
        try {
            return tableRestoDAO.findLibres();
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors du chargement des tables libres.", e);
        }
    }

    public void modifierTable(TableResto table) {
        try {
            tableRestoDAO.update(table);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la mise a jour de la table.", e);
        }
    }

    public void supprimerTable(int numeroTable) {
        try {
            tableRestoDAO.delete(numeroTable);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la suppression de la table.", e);
        }
    }

    public void reserverTable(int numeroTable) {
        try {
            tableRestoDAO.reserver(numeroTable);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la reservation de la table.", e);
        }
    }

    public void libererTable(int numeroTable) {
        try {
            tableRestoDAO.liberer(numeroTable);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la liberation de la table.", e);
        }
    }

    public TableResto getTableParNumero(int numeroTable) {
        try {
            return tableRestoDAO.findByNumero(numeroTable);
        } catch (SQLException e) {
            throw new IllegalStateException("Erreur lors de la recherche de la table.", e);
        }
    }

    public List<TableResto> rechercherParEtat(String etat) {
        List<TableResto> resultat = new ArrayList<>();
        String filtre = etat == null ? "" : etat.trim().toLowerCase();
        for (TableResto table : getToutesLesTables()) {
            if (table.getEtat() != null && table.getEtat().toLowerCase().contains(filtre)) {
                resultat.add(table);
            }
        }
        return resultat;
    }
}
