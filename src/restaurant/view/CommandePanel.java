package restaurant.view;

import java.awt.BorderLayout;
import java.awt.FlowLayout;
import java.awt.GridBagConstraints;
import java.awt.GridBagLayout;
import java.awt.Insets;
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

import restaurant.controller.CommandeController;
import restaurant.model.Commande;

public class CommandePanel extends JPanel {
    private final CommandeController controller = new CommandeController();
    private final DefaultTableModel tableModel =
        new DefaultTableModel(new Object[] {"ID Commande", "Date", "Total"}, 0);
    private final JTable table = new JTable(tableModel);
    private final JTextField idCommandeField = new JTextField();
    private final JTextField idClientField = new JTextField();
    private final JTextField numeroTableField = new JTextField();
    private final JTextField idEmployeField = new JTextField();
    private final JTextField idPlatField = new JTextField();
    private final JTextField quantiteField = new JTextField();

    public CommandePanel() {
        setLayout(new BorderLayout(10, 10));
        setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));

        JPanel topPanel = new JPanel(new BorderLayout(10, 10));
        topPanel.add(buildFormPanel(), BorderLayout.CENTER);
        topPanel.add(buildActionPanel(), BorderLayout.SOUTH);

        add(topPanel, BorderLayout.NORTH);
        add(new JScrollPane(table), BorderLayout.CENTER);

        table.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
        table.getSelectionModel().addListSelectionListener(e -> remplirChampsDepuisTable());

        refreshData();
        UIStyles.stylePanelTree(this);
    }

    private JPanel buildFormPanel() {
        JPanel panel = new JPanel(new GridBagLayout());
        panel.setBorder(BorderFactory.createTitledBorder("Formulaire commande"));

        GridBagConstraints gbc = new GridBagConstraints();
        gbc.insets = new Insets(6, 6, 6, 6);
        gbc.fill = GridBagConstraints.HORIZONTAL;
        gbc.weightx = 1;

        addField(panel, gbc, 0, 0, "ID Commande", idCommandeField);
        addField(panel, gbc, 1, 0, "ID Client", idClientField);
        addField(panel, gbc, 2, 0, "Numero Table", numeroTableField);
        addField(panel, gbc, 3, 0, "ID Employe", idEmployeField);

        addField(panel, gbc, 0, 1, "ID Plat", idPlatField);
        addField(panel, gbc, 1, 1, "Quantite", quantiteField);

        return panel;
    }

    private void addField(JPanel panel, GridBagConstraints gbc, int x, int y, String label, JTextField field) {
        gbc.gridx = x;
        gbc.gridy = y * 2;
        gbc.weightx = 1;
        panel.add(new JLabel(label), gbc);

        gbc.gridy = y * 2 + 1;
        field.setColumns(12);
        panel.add(field, gbc);
    }

    private JPanel buildActionPanel() {
        JPanel panel = new JPanel(new FlowLayout(FlowLayout.LEFT, 8, 6));

        JButton creerBtn = new JButton("Creer");
        JButton modifierBtn = new JButton("Modifier");
        JButton supprimerBtn = new JButton("Supprimer");
        JButton afficherBtn = new JButton("Afficher tout");
        JButton ajouterPlatBtn = new JButton("Ajouter plat");
        JButton totalBtn = new JButton("Calculer total");
        JButton viderBtn = new JButton("Vider");

        creerBtn.addActionListener(e -> creerCommande());
        modifierBtn.addActionListener(e -> modifierCommande());
        supprimerBtn.addActionListener(e -> supprimerCommande());
        afficherBtn.addActionListener(e -> chargerCommandes());
        ajouterPlatBtn.addActionListener(e -> ajouterPlat());
        totalBtn.addActionListener(e -> calculerTotal());
        viderBtn.addActionListener(e -> viderChamps());

        panel.add(creerBtn);
        panel.add(modifierBtn);
        panel.add(supprimerBtn);
        panel.add(afficherBtn);
        panel.add(ajouterPlatBtn);
        panel.add(totalBtn);
        panel.add(viderBtn);

        return panel;
    }

    private void chargerCommandes() {
        List<Commande> commandes = controller.getToutesLesCommandes();
        tableModel.setRowCount(0);
        for (Commande commande : commandes) {
            tableModel.addRow(new Object[] {
                commande.getIdCommande(),
                commande.getDate(),
                controller.calculerTotalCommande(commande.getIdCommande())
            });
        }
    }

    public void refreshData() {
        chargerCommandes();
    }

    private void creerCommande() {
        try {
            int idCommande = controller.creerCommande(
                Integer.parseInt(idClientField.getText()),
                Integer.parseInt(numeroTableField.getText()),
                Integer.parseInt(idEmployeField.getText())
            );
            idCommandeField.setText(String.valueOf(idCommande));
            chargerCommandes();
            message("Commande creee avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void modifierCommande() {
        try {
            controller.modifierCommande(
                Integer.parseInt(idCommandeField.getText()),
                Integer.parseInt(idClientField.getText()),
                Integer.parseInt(numeroTableField.getText()),
                Integer.parseInt(idEmployeField.getText())
            );
            chargerCommandes();
            message("Commande modifiee avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void supprimerCommande() {
        try {
            if (idCommandeField.getText().trim().isEmpty()) {
                throw new IllegalStateException("Selectionnez d'abord une commande a supprimer.");
            }
            controller.supprimerCommande(Integer.parseInt(idCommandeField.getText()));
            chargerCommandes();
            viderChamps();
            message("Commande supprimee avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void ajouterPlat() {
        try {
            controller.ajouterPlatACommande(
                Integer.parseInt(idCommandeField.getText()),
                Integer.parseInt(idPlatField.getText()),
                Integer.parseInt(quantiteField.getText())
            );
            chargerCommandes();
            message("Plat ajoute a la commande.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void calculerTotal() {
        try {
            double total = controller.calculerTotalCommande(Integer.parseInt(idCommandeField.getText()));
            JOptionPane.showMessageDialog(this, "Total de la commande : " + total + " DH");
            chargerCommandes();
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void remplirChampsDepuisTable() {
        int row = table.getSelectedRow();
        if (row < 0) {
            return;
        }
        idCommandeField.setText(String.valueOf(tableModel.getValueAt(row, 0)));
        Commande commande = controller.getCommandeParId(Integer.parseInt(idCommandeField.getText()));
        if (commande != null) {
            idCommandeField.setText(String.valueOf(commande.getIdCommande()));
        }
    }

    private void viderChamps() {
        idCommandeField.setText("");
        idClientField.setText("");
        numeroTableField.setText("");
        idEmployeField.setText("");
        idPlatField.setText("");
        quantiteField.setText("");
        table.clearSelection();
    }

    private void message(String texte) {
        JOptionPane.showMessageDialog(this, texte);
    }

    private void erreur(Exception ex) {
        JOptionPane.showMessageDialog(this, UIStyles.getErrorMessage(ex), "Erreur", JOptionPane.ERROR_MESSAGE);
    }
}
