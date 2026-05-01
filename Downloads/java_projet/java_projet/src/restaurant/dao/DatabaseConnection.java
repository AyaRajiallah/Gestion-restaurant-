package restaurant.dao;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DatabaseConnection {
    private static final String URL      = "jdbc:sqlserver://localhost:1433;database=GestionRestaurant;encrypt=true;trustServerCertificate=true";
    private static final String USER     = "restaurant_user";
    private static final String PASSWORD = "123456";

    private static Connection instance = null;

    public static Connection getConnection() throws SQLException {
        if (instance == null || instance.isClosed()) {
            try {
                Class.forName("com.microsoft.sqlserver.jdbc.SQLServerDriver");
                instance = DriverManager.getConnection(URL, USER, PASSWORD);
                System.out.println("Connexion établie.");
            } catch (ClassNotFoundException e) {
                throw new SQLException("Driver JDBC introuvable.", e);
            }
        }
        return instance;
    }
}