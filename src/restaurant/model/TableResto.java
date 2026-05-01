package restaurant.model;

public class TableResto {
 private int numero;
    private int capacite;
    private String etat;

    

    public TableResto(int numero, int capacite, String etat) {
        this.numero = numero;
        this.capacite = capacite;
        this.etat = etat;
    }
    


    public int getNumero() {
        return numero;
    }



    public void setNumero(int numero) {
        this.numero = numero;
    }



    public int getCapacite() {
        return capacite;
    }



    public void setCapacite(int capacite) {
        this.capacite = capacite;
    }



    public String getEtat() {
        return etat;
    }



    public void setEtat(String etat) {
        this.etat = etat;
    }



    public void reserver() {
        etat = "occupée";
    }

    public void liberer() {
        etat = "libre";
    }
}
