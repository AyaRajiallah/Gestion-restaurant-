package restaurant.model;

public class Client {
private int idClient;
private String nom;
private String telephone;

public Client(int idClient, String nom, String telephone) {
    this.idClient = idClient;
    this.nom = nom;
    this.telephone = telephone;
}

public Client() {
}

public int getIdClient() {
    return idClient;
}

public String getNom() {
    return nom;
}

public String getTelephone() {
    return telephone;
}

public void setIdClient(int idClient) {
    this.idClient = idClient;
}

public void setNom(String nom) {
    this.nom = nom;
}

public void setTelephone(String telephone) {
    this.telephone = telephone;
}

@Override
public String toString() {
    return "Client [idClient=" + idClient + ", nom=" + nom + ", telephone=" + telephone + "]";
}



}
