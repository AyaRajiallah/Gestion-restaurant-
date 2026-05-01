package restaurant.dao;

import restaurant.model.Plat;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class PlatDAO {

    public void insert(Plat p) throws SQLException {
        String sql = "INSERT INTO Plat (nom_plat, categorie, prix, disponible) VALUES (?, ?, ?, ?)";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setString(1, p.getNom());
            ps.setString(2, p.getCategorie());
            ps.setDouble(3, p.getPrix());
            ps.setBoolean(4, true);
            ps.executeUpdate();
            System.out.println("Plat ajoute : " + p.getNom());
        }
    }

    public List<Plat> findAll() throws SQLException {
        List<Plat> list = new ArrayList<>();
        String sql = "SELECT * FROM Plat WHERE disponible = 1";
        try (Connection con = DatabaseConnection.getConnection();
             Statement st = con.createStatement();
             ResultSet rs = st.executeQuery(sql)) {
            while (rs.next()) {
                Plat p = new Plat();
                p.setIdPlat(rs.getInt("id_plat"));
                p.setNom(rs.getString("nom_plat"));
                p.setCategorie(rs.getString("categorie"));
                p.setPrix(rs.getDouble("prix"));
                list.add(p);
            }
        }
        return list;
    }

    public List<Plat> findByCategorie(String categorie) throws SQLException {
        List<Plat> list = new ArrayList<>();
        String sql = "SELECT * FROM Plat WHERE categorie = ? AND disponible = 1";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setString(1, categorie);
            ResultSet rs = ps.executeQuery();
            while (rs.next()) {
                Plat p = new Plat();
                p.setIdPlat(rs.getInt("id_plat"));
                p.setNom(rs.getString("nom_plat"));
                p.setCategorie(rs.getString("categorie"));
                p.setPrix(rs.getDouble("prix"));
                list.add(p);
            }
        }
        return list;
    }

    public Plat findById(int id) throws SQLException {
        String sql = "SELECT * FROM Plat WHERE id_plat = ? AND disponible = 1";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, id);
            ResultSet rs = ps.executeQuery();
            if (rs.next()) {
                Plat p = new Plat();
                p.setIdPlat(rs.getInt("id_plat"));
                p.setNom(rs.getString("nom_plat"));
                p.setCategorie(rs.getString("categorie"));
                p.setPrix(rs.getDouble("prix"));
                return p;
            }
        }
        return null;
    }

    public void update(Plat p) throws SQLException {
        String sql = "UPDATE Plat SET nom_plat = ?, categorie = ?, prix = ? WHERE id_plat = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setString(1, p.getNom());
            ps.setString(2, p.getCategorie());
            ps.setDouble(3, p.getPrix());
            ps.setInt(4, p.getIdPlat());
            ps.executeUpdate();
            System.out.println("Plat mis a jour : " + p.getNom());
        }
    }

    public void delete(int id) throws SQLException {
        String sql = "UPDATE Plat SET disponible = 0 WHERE id_plat = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, id);
            int affected = ps.executeUpdate();
            if (affected == 0) {
                throw new SQLException("Aucun plat trouve avec l'id " + id + ".");
            }
            System.out.println("Plat desactive (id=" + id + ")");
        }
    }
}
