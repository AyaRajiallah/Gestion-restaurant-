package restaurant.dao;

import restaurant.model.TableResto;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class TableRestoDAO {

    public void insert(TableResto t) throws SQLException {
        String sql = "INSERT INTO TableRestaurant (numero_table, capacite, etat) VALUES (?, ?, ?)";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, t.getNumero());
            ps.setInt(2, t.getCapacite());
            ps.setString(3, normalizeEtat(t.getEtat()));
            ps.executeUpdate();
            System.out.println("Table ajoutee : n°" + t.getNumero());
        }
    }

    public List<TableResto> findAll() throws SQLException {
        List<TableResto> list = new ArrayList<>();
        String sql = "SELECT * FROM TableRestaurant";
        try (Connection con = DatabaseConnection.getConnection();
             Statement st = con.createStatement();
             ResultSet rs = st.executeQuery(sql)) {
            while (rs.next()) {
                TableResto t = new TableResto(
                    rs.getInt("numero_table"),
                    rs.getInt("capacite"),
                    normalizeEtat(rs.getString("etat"))
                );
                list.add(t);
            }
        }
        return list;
    }

    public List<TableResto> findLibres() throws SQLException {
        List<TableResto> list = new ArrayList<>();
        String sql = "SELECT * FROM TableRestaurant WHERE etat IN ('Disponible', 'libre')";
        try (Connection con = DatabaseConnection.getConnection();
             Statement st = con.createStatement();
             ResultSet rs = st.executeQuery(sql)) {
            while (rs.next()) {
                list.add(new TableResto(
                    rs.getInt("numero_table"),
                    rs.getInt("capacite"),
                    normalizeEtat(rs.getString("etat"))
                ));
            }
        }
        return list;
    }

    public TableResto findByNumero(int numero) throws SQLException {
        String sql = "SELECT * FROM TableRestaurant WHERE numero_table = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, numero);
            ResultSet rs = ps.executeQuery();
            if (rs.next()) {
                return new TableResto(
                    rs.getInt("numero_table"),
                    rs.getInt("capacite"),
                    normalizeEtat(rs.getString("etat"))
                );
            }
        }
        return null;
    }

    public void update(TableResto t) throws SQLException {
        String sql = "UPDATE TableRestaurant SET capacite = ?, etat = ? WHERE numero_table = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, t.getCapacite());
            ps.setString(2, normalizeEtat(t.getEtat()));
            ps.setInt(3, t.getNumero());
            ps.executeUpdate();
            System.out.println("Table mise a jour : n°" + t.getNumero());
        }
    }

    public void delete(int numero) throws SQLException {
        String sql = "DELETE FROM TableRestaurant WHERE numero_table = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, numero);
            int affected = ps.executeUpdate();
            if (affected == 0) {
                throw new SQLException("Aucune table trouvee avec le numero " + numero + ".");
            }
            System.out.println("Table supprimee : n°" + numero);
        }
    }

    public void reserver(int numero) throws SQLException {
        String sql = "UPDATE TableRestaurant SET etat='Occupee' WHERE numero_table=?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, numero);
            ps.executeUpdate();
            System.out.println("Table n°" + numero + " reservee.");
        }
    }

    public void liberer(int numero) throws SQLException {
        String sql = "UPDATE TableRestaurant SET etat='Disponible' WHERE numero_table=?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, numero);
            ps.executeUpdate();
            System.out.println("Table n°" + numero + " liberee.");
        }
    }

    private String normalizeEtat(String etat) {
        if (etat == null) {
            return "Disponible";
        }
        String value = etat.trim().toLowerCase();
        if (value.equals("libre") || value.equals("disponible")) {
            return "Disponible";
        }
        if (value.equals("occupee") || value.equals("occupée") || value.contains("occup")) {
            return "Occupee";
        }
        return etat;
    }
}
