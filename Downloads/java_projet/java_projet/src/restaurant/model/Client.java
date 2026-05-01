package restaurant.model;

public class Client implements Affichable {
private int idClient;
private String nom;
private String telephone;
private String adresse;

public Client(int idClient, String nom, String telephone, String adresse) {
    this.idClient = idClient;
    this.nom = nom;
    this.telephone = telephone;
    this.adresse = adresse;
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

public String getAdresse() {
    return adresse;
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

public void setAdresse(String adresse) {
    this.adresse = adresse;
}

@Override
public String toString() {
    return "Client [id=" + idClient + ", nom=" + nom + ", tel=" + telephone + ", adresse=" + adresse + "]";
}

@Override
public void afficherDetails() {
    System.out.println(toString());
}


}
