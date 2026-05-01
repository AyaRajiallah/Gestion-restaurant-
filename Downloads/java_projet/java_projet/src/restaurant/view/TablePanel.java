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

import restaurant.controller.TableRestoController;
import restaurant.model.TableResto;

public class TablePanel extends JPanel {
    private final TableRestoController controller = new TableRestoController();
    private final DefaultTableModel tableModel =
        new DefaultTableModel(new Object[] {"Numero", "Capacite", "Etat"}, 0);
    private final JTable table = new JTable(tableModel);
    private final JTextField numeroField = new JTextField();
    private final JTextField capaciteField = new JTextField();
    private final JComboBox<String> etatBox = new JComboBox<>(new String[] {"Disponible", "Occupee"});

    public TablePanel() {
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
        JPanel panel = new JPanel(new GridLayout(2, 4, 8, 8));
        panel.setBorder(BorderFactory.createTitledBorder("Formulaire table"));

        panel.add(new JLabel("Numero"));
        panel.add(new JLabel("Capacite"));
        panel.add(new JLabel("Etat"));
        panel.add(new JLabel(""));
        panel.add(numeroField);
        panel.add(capaciteField);
        panel.add(etatBox);
        panel.add(new JLabel(""));

        return panel;
    }

    private JPanel buildActionPanel() {
        JPanel panel = new JPanel(new GridLayout(1, 7, 8, 8));

        JButton ajouterBtn = new JButton("Ajouter");
        JButton modifierBtn = new JButton("Modifier");
        JButton supprimerBtn = new JButton("Supprimer");
        JButton reserverBtn = new JButton("Reserver");
        JButton libererBtn = new JButton("Liberer");
        JButton libresBtn = new JButton("Tables libres");
        JButton afficherBtn = new JButton("Afficher tout");

        ajouterBtn.addActionListener(e -> ajouterTable());
        modifierBtn.addActionListener(e -> modifierTable());
        supprimerBtn.addActionListener(e -> supprimerTable());
        reserverBtn.addActionListener(e -> reserverTable());
        libererBtn.addActionListener(e -> libererTable());
        libresBtn.addActionListener(e -> chargerTables(controller.getTablesLibres()));
        afficherBtn.addActionListener(e -> chargerTables(controller.getToutesLesTables()));

        panel.add(ajouterBtn);
        panel.add(modifierBtn);
        panel.add(supprimerBtn);
        panel.add(reserverBtn);
        panel.add(libererBtn);
        panel.add(libresBtn);
        panel.add(afficherBtn);

        return panel;
    }

    private void chargerTables(List<TableResto> tables) {
        tableModel.setRowCount(0);
        for (TableResto tableResto : tables) {
            tableModel.addRow(new Object[] {
                tableResto.getNumero(),
                tableResto.getCapacite(),
                normalizeEtat(tableResto.getEtat())
            });
        }
    }

    public void refreshData() {
        chargerTables(controller.getToutesLesTables());
    }

    private void ajouterTable() {
        try {
            TableResto tableResto = new TableResto(
                Integer.parseInt(numeroField.getText()),
                Integer.parseInt(capaciteField.getText()),
                (String) etatBox.getSelectedItem()
            );
            controller.ajouterTable(tableResto);
            chargerTables(controller.getToutesLesTables());
            message("Table ajoutee avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void modifierTable() {
        try {
            TableResto tableResto = new TableResto(
                Integer.parseInt(numeroField.getText()),
                Integer.parseInt(capaciteField.getText()),
                (String) etatBox.getSelectedItem()
            );
            controller.modifierTable(tableResto);
            chargerTables(controller.getToutesLesTables());
            message("Table modifiee avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void supprimerTable() {
        try {
            if (numeroField.getText().trim().isEmpty()) {
                throw new IllegalStateException("Selectionnez d'abord une table a supprimer.");
            }
            controller.supprimerTable(Integer.parseInt(numeroField.getText()));
            chargerTables(controller.getToutesLesTables());
            viderChamps();
            message("Table supprimee avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void reserverTable() {
        try {
            controller.reserverTable(Integer.parseInt(numeroField.getText()));
            chargerTables(controller.getToutesLesTables());
            message("Table reservee avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void libererTable() {
        try {
            controller.libererTable(Integer.parseInt(numeroField.getText()));
            chargerTables(controller.getToutesLesTables());
            message("Table liberee avec succes.");
        } catch (Exception ex) {
            erreur(ex);
        }
    }

    private void remplirChampsDepuisTable() {
        int row = table.getSelectedRow();
        if (row < 0) {
            return;
        }
        numeroField.setText(String.valueOf(tableModel.getValueAt(row, 0)));
        capaciteField.setText(String.valueOf(tableModel.getValueAt(row, 1)));
        etatBox.setSelectedItem(normalizeEtat(String.valueOf(tableModel.getValueAt(row, 2))));
    }

    private void viderChamps() {
        numeroField.setText("");
        capaciteField.setText("");
        etatBox.setSelectedIndex(0);
        table.clearSelection();
    }

    private void message(String texte) {
        JOptionPane.showMessageDialog(this, texte);
    }

    private void erreur(Exception ex) {
        JOptionPane.showMessageDialog(this, UIStyles.getErrorMessage(ex), "Erreur", JOptionPane.ERROR_MESSAGE);
    }

    private String normalizeEtat(String etat) {
        if (etat == null) {
            return "Disponible";
        }
        String value = etat.trim().toLowerCase();
        if (value.equals("libre") || value.equals("disponible")) {
            return "Disponible";
        }
        if (value.equals("occupee") || value.equals("occupée") || value.contains("occup")) {
            return "Occupee";
        }
        return "Disponible";
    }
}
