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

import restaurant.controller.PlatController;
import restaurant.model.Plat;

public class PlatPanel extends JPanel {
    private final PlatController controller = new PlatController();
    private final DefaultTableModel tableModel =
        new DefaultTableModel(new Object[] {"ID", "Nom", "Prix", "Categorie"}, 0);
    private final JTable table = new JTable(tableModel);
    private final JTextField idField = new JTextField();
    private final JTextField nomField = new JTextField();
    private final JTextField prixField = new JTextField();
    private final JTextField categorieField = new JTextField();
    private final JTextField rechercheField = new JTextField();

    public PlatPanel() {
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
        panel.setBorder(BorderFactory.createTitledBorder("Formulaire plat"));

        panel.add(new JLabel("ID"));
        panel.add(new JLabel("Nom"));
        panel.add(new JLabel("Prix"));
        panel.add(new JLabel("Categorie"));
        panel.add(idField);
        panel.add(nomField);
        panel.add(prixField);
        panel.add(categorieField);
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

        ajouterBtn.addActionListener(e -> ajouterPlat());
        modifierBtn.addActionListener(e -> modifierPlat());
        supprimerBtn.addActionListener(e -> supprimerPlat());
        rechercherBtn.addActionListener(e -> chargerPlats(controller.rechercherParNom(rechercheField.getText())));
        afficherBtn.addActionListener(e -> chargerPlats(controller.getTousLesPlats()));
        viderBtn.addActionListener(e -> viderChamps());

        panel.add(ajouterBtn);
        panel.add(modifierBtn);
        panel.add(supprimerBtn);
        panel.add(rechercherBtn);
        panel.add(afficherBtn);
        panel.add(viderBtn);

        return panel;
    }

    private void chargerPlats(List<Plat> plats) {
        tableModel.setRowCount(0);
        for (Plat plat : plats) {
            tableModel.addRow(new Object[] {
                plat.getIdPlat(),
                plat.getNom(),
                plat.getPrix(),
                plat.getCategorie()
            });
        }
    }

    public void refreshData() {
        chargerPlats(controller.getTousLesPlats());
    }

    private void ajouterPlat() {
        try {
            Plat plat = new Plat();
            plat.setNom(nomField.getText());
            plat.setPrix(Double.parseDouble(prixField.getText()));
            plat.setCategorie(categorieField.getText());
            controller.ajouterPlat(plat);
            chargerPlats(controller.getTousLesPlats());
            viderChamps();
            message("Plat ajoute avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void modifierPlat() {
        try {
            Plat plat = new Plat();
            plat.setIdPlat(Integer.parseInt(idField.getText()));
            plat.setNom(nomField.getText());
            plat.setPrix(Double.parseDouble(prixField.getText()));
            plat.setCategorie(categorieField.getText());
            controller.modifierPlat(plat);
            chargerPlats(controller.getTousLesPlats());
            message("Plat modifie avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void supprimerPlat() {
        try {
            if (idField.getText().trim().isEmpty()) {
                throw new IllegalStateException("Selectionnez d'abord un plat a supprimer.");
            }
            controller.supprimerPlat(Integer.parseInt(idField.getText()));
            chargerPlats(controller.getTousLesPlats());
            viderChamps();
            message("Plat supprime avec succes.");
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
        prixField.setText(String.valueOf(tableModel.getValueAt(row, 2)));
        categorieField.setText(String.valueOf(tableModel.getValueAt(row, 3)));
    }

    private void viderChamps() {
        idField.setText("");
        nomField.setText("");
        prixField.setText("");
        categorieField.setText("");
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
