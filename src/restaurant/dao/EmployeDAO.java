package restaurant.dao;

import restaurant.model.*;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class EmployeDAO {

    public void insert(Employe e, String role) throws SQLException {
        String sql = "INSERT INTO Employe (nom, role, salaire) VALUES (?, ?, ?)";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setString(1, e.getNom());
            ps.setString(2, role);
            ps.setDouble(3, 0);
            ps.executeUpdate();
            System.out.println("Employe ajoute : " + e.getNom());
        }
    }

    public List<Employe> findAll() throws SQLException {
        List<Employe> list = new ArrayList<>();
        String sql = "SELECT * FROM Employe";
        try (Connection con = DatabaseConnection.getConnection();
             Statement st = con.createStatement();
             ResultSet rs = st.executeQuery(sql)) {
            while (rs.next()) {
                list.add(buildEmploye(rs));
            }
        }
        return list;
    }

    public List<Employe> findByRole(String role) throws SQLException {
        List<Employe> list = new ArrayList<>();
        String sql = "SELECT * FROM Employe WHERE role = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setString(1, role);
            ResultSet rs = ps.executeQuery();
            while (rs.next()) {
                list.add(buildEmploye(rs));
            }
        }
        return list;
    }

    public Employe findById(int id) throws SQLException {
        String sql = "SELECT * FROM Employe WHERE id_employe = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, id);
            ResultSet rs = ps.executeQuery();
            if (rs.next()) {
                return buildEmploye(rs);
            }
        }
        return null;
    }

    public void update(Employe e, String role) throws SQLException {
        String sql = "UPDATE Employe SET nom = ?, role = ? WHERE id_employe = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setString(1, e.getNom());
            ps.setString(2, role);
            ps.setInt(3, e.getId());
            ps.executeUpdate();
            System.out.println("Employe mis a jour : " + e.getNom());
        }
    }

    public void delete(int id) throws SQLException {
        String sql = "DELETE FROM Employe WHERE id_employe = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, id);
            int affected = ps.executeUpdate();
            if (affected == 0) {
                throw new SQLException("Aucun employe trouve avec l'id " + id + ".");
            }
            System.out.println("Employe supprime (id=" + id + ")");
        }
    }

    private Employe buildEmploye(ResultSet rs) throws SQLException {
        String role = rs.getString("role");
        int id = rs.getInt("id_employe");
        String nom = rs.getString("nom");
        switch (role) {
            case "Serveur":
                return new Serveur(id, nom);
            case "Cuisinier":
                return new Cuisinier(id, nom);
            case "Caissier":
                return new Caissier(id, nom);
            default:
                return new Serveur(id, nom);
        }
    }
}
