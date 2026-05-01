package restaurant.view;

import java.awt.BorderLayout;
import java.awt.GridLayout;
import java.util.List;

import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.ListSelectionModel;
import javax.swing.table.DefaultTableModel;

import restaurant.controller.EmployeController;
import restaurant.model.Caissier;
import restaurant.model.Cuisinier;
import restaurant.model.Employe;
import restaurant.model.Serveur;

public class EmployePanel extends JPanel {
    private final EmployeController controller = new EmployeController();
    private final DefaultTableModel tableModel =
        new DefaultTableModel(new Object[] {"ID", "Nom", "Role"}, 0);
    private final JTable table = new JTable(tableModel);
    private final JTextField idField = new JTextField();
    private final JTextField nomField = new JTextField();
    private final JComboBox<String> roleBox = new JComboBox<>(new String[] {"Serveur", "Cuisinier", "Caissier"});
    private final JTextField rechercheField = new JTextField();

    public EmployePanel() {
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
        panel.setBorder(BorderFactory.createTitledBorder("Formulaire employe"));

        panel.add(new JLabel("ID"));
        panel.add(new JLabel("Nom"));
        panel.add(new JLabel("Role"));
        panel.add(new JLabel(""));
        panel.add(idField);
        panel.add(nomField);
        panel.add(roleBox);
        panel.add(new JLabel(""));
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
        JButton filtrerBtn = new JButton("Filtrer role");
        JButton afficherBtn = new JButton("Afficher tout");

        ajouterBtn.addActionListener(e -> ajouterEmploye());
        modifierBtn.addActionListener(e -> modifierEmploye());
        supprimerBtn.addActionListener(e -> supprimerEmploye());
        rechercherBtn.addActionListener(e -> chargerEmployes(controller.rechercherParNom(rechercheField.getText())));
        filtrerBtn.addActionListener(e -> chargerEmployes(controller.getEmployesParRole((String) roleBox.getSelectedItem())));
        afficherBtn.addActionListener(e -> chargerEmployes(controller.getTousLesEmployes()));

        panel.add(ajouterBtn);
        panel.add(modifierBtn);
        panel.add(supprimerBtn);
        panel.add(rechercherBtn);
        panel.add(filtrerBtn);
        panel.add(afficherBtn);

        return panel;
    }

    private void chargerEmployes(List<Employe> employes) {
        tableModel.setRowCount(0);
        for (Employe employe : employes) {
            tableModel.addRow(new Object[] {
                employe.getId(),
                employe.getNom(),
                employe.getClass().getSimpleName()
            });
        }
    }

    public void refreshData() {
        chargerEmployes(controller.getTousLesEmployes());
    }

    private void ajouterEmploye() {
        try {
            String role = (String) roleBox.getSelectedItem();
            Employe employe = buildEmploye(0, nomField.getText(), role);
            controller.ajouterEmploye(employe, role);
            chargerEmployes(controller.getTousLesEmployes());
            viderChamps();
            message("Employe ajoute avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void modifierEmploye() {
        try {
            String role = (String) roleBox.getSelectedItem();
            Employe employe = buildEmploye(Integer.parseInt(idField.getText()), nomField.getText(), role);
            controller.modifierEmploye(employe, role);
            chargerEmployes(controller.getTousLesEmployes());
            message("Employe modifie avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void supprimerEmploye() {
        try {
            if (idField.getText().trim().isEmpty()) {
                throw new IllegalStateException("Selectionnez d'abord un employe a supprimer.");
            }
            controller.supprimerEmploye(Integer.parseInt(idField.getText()));
            chargerEmployes(controller.getTousLesEmployes());
            viderChamps();
            message("Employe supprime avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private Employe buildEmploye(int id, String nom, String role) {
        if ("Cuisinier".equals(role)) {
            return new Cuisinier(id, nom);
        }
        if ("Caissier".equals(role)) {
            return new Caissier(id, nom);
        }
        return new Serveur(id, nom);
    }

    private void remplirChampsDepuisTable() {
        int row = table.getSelectedRow();
        if (row < 0) {
            return;
        }
        idField.setText(String.valueOf(tableModel.getValueAt(row, 0)));
        nomField.setText(String.valueOf(tableModel.getValueAt(row, 1)));
        roleBox.setSelectedItem(String.valueOf(tableModel.getValueAt(row, 2)));
    }

    private void viderChamps() {
        idField.setText("");
        nomField.setText("");
        rechercheField.setText("");
        roleBox.setSelectedIndex(0);
        table.clearSelection();
    }

    private void message(String texte) {
        JOptionPane.showMessageDialog(this, texte);
    }

    private void erreur(Exception ex) {
        JOptionPane.showMessageDialog(this, UIStyles.getErrorMessage(ex), "Erreur", JOptionPane.ERROR_MESSAGE);
    }
}
