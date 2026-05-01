package restaurant.dao;

import restaurant.model.Client;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ClientDAO {

    public void insert(Client c) throws SQLException {
        String sql = "INSERT INTO Client (nom, telephone, adresse) VALUES (?, ?, ?)";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setString(1, c.getNom());
            ps.setString(2, c.getTelephone());
            ps.setString(3, c.getAdresse());
            ps.executeUpdate();
            System.out.println("Client ajoute : " + c.getNom());
        }
    }

    public List<Client> findAll() throws SQLException {
        List<Client> list = new ArrayList<>();
        String sql = "SELECT * FROM Client";
        try (Connection con = DatabaseConnection.getConnection();
             Statement st = con.createStatement();
             ResultSet rs = st.executeQuery(sql)) {
            while (rs.next()) {
                Client c = new Client();
                c.setIdClient(rs.getInt("id_client"));
                c.setNom(rs.getString("nom"));
                c.setTelephone(rs.getString("telephone"));
                c.setAdresse(rs.getString("adresse"));
                list.add(c);
            }
        }
        return list;
    }

    public Client findById(int id) throws SQLException {
        String sql = "SELECT * FROM Client WHERE id_client = ?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, id);
            ResultSet rs = ps.executeQuery();
            if (rs.next()) {
                Client c = new Client();
                c.setIdClient(rs.getInt("id_client"));
                c.setNom(rs.getString("nom"));
                c.setTelephone(rs.getString("telephone"));
                c.setAdresse(rs.getString("adresse"));
                return c;
            }
        }
        return null;
    }

    public void update(Client c) throws SQLException {
        String sql = "UPDATE Client SET nom=?, telephone=?, adresse=? WHERE id_client=?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setString(1, c.getNom());
            ps.setString(2, c.getTelephone());
            ps.setString(3, c.getAdresse());
            ps.setInt(4, c.getIdClient());
            ps.executeUpdate();
            System.out.println("Client mis a jour : " + c.getNom());
        }
    }

    public void delete(int id) throws SQLException {
        String sql = "DELETE FROM Client WHERE id_client=?";
        try (Connection con = DatabaseConnection.getConnection();
             PreparedStatement ps = con.prepareStatement(sql)) {
            ps.setInt(1, id);
            int affected = ps.executeUpdate();
            if (affected == 0) {
                throw new SQLException("Aucun client trouve avec l'id " + id + ".");
            }
            System.out.println("Client supprime (id=" + id + ")");
        }
    }
}
