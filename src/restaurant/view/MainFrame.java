package restaurant.view;

import java.awt.BorderLayout;
import java.awt.GridLayout;

import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTabbedPane;

public class MainFrame extends JFrame {
    private final ClientPanel clientPanel;
    private final PlatPanel platPanel;
    private final EmployePanel employePanel;
    private final TablePanel tablePanel;
    private final CommandePanel commandePanel;

    public MainFrame() {
        setTitle("Gestion de Restaurant");
        setSize(1200, 760);
        setLocationRelativeTo(null);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLayout(new BorderLayout(12, 12));
        getContentPane().setBackground(UIStyles.BG);

        JPanel hero = new JPanel(new GridLayout(2, 1, 0, 4));
        hero.setBackground(UIStyles.HEADER);
        hero.setBorder(javax.swing.BorderFactory.createEmptyBorder(18, 18, 14, 18));
        JLabel title = UIStyles.createHeroTitle("Application de Gestion de Restaurant");
        JLabel subtitle = UIStyles.createHeroSubtitle("Suivi des clients, plats, employes, tables et commandes");
        hero.add(title);
        hero.add(subtitle);
        add(hero, BorderLayout.NORTH);

        clientPanel = new ClientPanel();
        platPanel = new PlatPanel();
        employePanel = new EmployePanel();
        tablePanel = new TablePanel();
        commandePanel = new CommandePanel();

        JTabbedPane tabs = new JTabbedPane();
        tabs.addTab("Clients", clientPanel);
        tabs.addTab("Plats", platPanel);
        tabs.addTab("Employes", employePanel);
        tabs.addTab("Tables", tablePanel);
        tabs.addTab("Commandes", commandePanel);
        tabs.addChangeListener(e -> refreshSelectedTab(tabs.getSelectedIndex()));

        add(tabs, BorderLayout.CENTER);
        UIStyles.stylePanelTree(this.getContentPane());
    }

    private void refreshSelectedTab(int index) {
        switch (index) {
            case 0 -> clientPanel.refreshData();
            case 1 -> platPanel.refreshData();
            case 2 -> employePanel.refreshData();
            case 3 -> tablePanel.refreshData();
            case 4 -> commandePanel.refreshData();
            default -> {
            }
        }
    }
}
