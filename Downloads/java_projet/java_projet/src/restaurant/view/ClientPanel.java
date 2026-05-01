package restaurant.view;

import java.awt.BorderLayout;
import java.awt.GridLayout;
import java.util.List;

import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.ListSelectionModel;
import javax.swing.table.DefaultTableModel;

import restaurant.controller.ClientController;
import restaurant.model.Client;

public class ClientPanel extends JPanel {
    private final ClientController controller = new ClientController();
    private final DefaultTableModel tableModel =
        new DefaultTableModel(new Object[] {"ID", "Nom", "Telephone", "Adresse"}, 0);
    private final JTable table = new JTable(tableModel);
    private final JTextField idField = new JTextField();
    private final JTextField nomField = new JTextField();
    private final JTextField telephoneField = new JTextField();
    private final JTextField adresseField = new JTextField();
    private final JTextField rechercheField = new JTextField();

    public ClientPanel() {
        setLayout(new BorderLayout(10, 10));
        setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));

        add(buildFormPanel(), BorderLayout.NORTH);
        add(new JScrollPane(table), BorderLayout.CENTER);
        add(buildActionPanel(), BorderLayout.SOUTH);

        table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
        table.getSelectionModel().addListSelectionListener(e -> remplirChampsDepuisTable());

        refreshData();
        UIStyles.stylePanelTree(this);
    }

    private JPanel buildFormPanel() {
        JPanel panel = new JPanel(new GridLayout(3, 4, 8, 8));
        panel.setBorder(BorderFactory.createTitledBorder("Formulaire client"));

        panel.add(new JLabel("ID"));
        panel.add(new JLabel("Nom"));
        panel.add(new JLabel("Telephone"));
        panel.add(new JLabel("Adresse"));
        panel.add(idField);
        panel.add(nomField);
        panel.add(telephoneField);
        panel.add(adresseField);
        panel.add(new JLabel("Recherche nom"));
        panel.add(rechercheField);
        panel.add(new JLabel(""));
        panel.add(new JLabel(""));

        return panel;
    }

    private JPanel buildActionPanel() {
        JPanel panel = new JPanel(new GridLayout(1, 6, 8, 8));

        JButton ajouterBtn = new JButton("Ajouter");
        JButton modifierBtn = new JButton("Modifier");
        JButton supprimerBtn = new JButton("Supprimer");
        JButton rechercherBtn = new JButton("Rechercher");
        JButton afficherBtn = new JButton("Afficher tout");
        JButton viderBtn = new JButton("Vider");

        ajouterBtn.addActionListener(e -> ajouterClient());
        modifierBtn.addActionListener(e -> modifierClient());
        supprimerBtn.addActionListener(e -> supprimerClient());
        rechercherBtn.addActionListener(e -> chargerClients(controller.rechercherParNom(rechercheField.getText())));
        afficherBtn.addActionListener(e -> chargerClients(controller.getTousLesClients()));
        viderBtn.addActionListener(e -> viderChamps());

        panel.add(ajouterBtn);
        panel.add(modifierBtn);
        panel.add(supprimerBtn);
        panel.add(rechercherBtn);
        panel.add(afficherBtn);
        panel.add(viderBtn);

        return panel;
    }

    private void chargerClients(List<Client> clients) {
        tableModel.setRowCount(0);
        for (Client client : clients) {
            tableModel.addRow(new Object[] {
                client.getIdClient(),
                client.getNom(),
                client.getTelephone(),
                client.getAdresse()
            });
        }
    }

    public void refreshData() {
        chargerClients(controller.getTousLesClients());
    }

    private void ajouterClient() {
        try {
            Client client = new Client();
            client.setNom(nomField.getText());
            client.setTelephone(telephoneField.getText());
            client.setAdresse(adresseField.getText());
            controller.ajouterClient(client);
            chargerClients(controller.getTousLesClients());
            viderChamps();
            message("Client ajoute avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void modifierClient() {
        try {
            Client client = new Client();
            client.setIdClient(Integer.parseInt(idField.getText()));
            client.setNom(nomField.getText());
            client.setTelephone(telephoneField.getText());
            client.setAdresse(adresseField.getText());
            controller.modifierClient(client);
            chargerClients(controller.getTousLesClients());
            message("Client modifie avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void supprimerClient() {
        try {
            if (idField.getText().trim().isEmpty()) {
                throw new IllegalStateException("Selectionnez d'abord un client a supprimer.");
            }
            controller.supprimerClient(Integer.parseInt(idField.getText()));
            chargerClients(controller.getTousLesClients());
            viderChamps();
            message("Client supprime avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void remplirChampsDepuisTable() {
        int row = table.getSelectedRow();
        if (row < 0) {
            return;
        }
        idField.setText(String.valueOf(tableModel.getValueAt(row, 0)));
        nomField.setText(String.valueOf(tableModel.getValueAt(row, 1)));
        telephoneField.setText(String.valueOf(tableModel.getValueAt(row, 2)));
        adresseField.setText(String.valueOf(tableModel.getValueAt(row, 3)));
    }

    private void viderChamps() {
        idField.setText("");
        nomField.setText("");
        telephoneField.setText("");
        adresseField.setText("");
        rechercheField.setText("");
        table.clearSelection();
    }

    private void message(String texte) {
        JOptionPane.showMessageDialog(this, texte);
    }

    private void erreur(Exception ex) {
        JOptionPane.showMessageDialog(this, UIStyles.getErrorMessage(ex), "Erreur", JOptionPane.ERROR_MESSAGE);
    }
}
