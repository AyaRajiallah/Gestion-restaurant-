package restaurant.view;

import java.awt.Color;
import java.awt.Component;
import java.awt.Container;
import java.awt.Font;

import javax.swing.BorderFactory;
import javax.swing.JButton;
import javax.swing.JComboBox;
import javax.swing.JComponent;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTabbedPane;
import javax.swing.JTable;
import javax.swing.JTextField;
import javax.swing.SwingConstants;
import javax.swing.border.Border;
import javax.swing.border.TitledBorder;
import javax.swing.table.JTableHeader;

public final class UIStyles {
    public static final Color BG = new Color(247, 242, 235);
    public static final Color CARD = new Color(255, 252, 247);
    public static final Color INK = new Color(46, 36, 28);
    public static final Color MUTED = new Color(112, 94, 78);
    public static final Color ACCENT = new Color(195, 94, 45);
    public static final Color ACCENT_DARK = new Color(137, 61, 27);
    public static final Color LINE = new Color(221, 206, 190);
    public static final Color HEADER = new Color(238, 228, 216);

    private static final Font TITLE_FONT = new Font("Georgia", Font.BOLD, 18);
    private static final Font LABEL_FONT = new Font("Segoe UI", Font.BOLD, 14);
    private static final Font BODY_FONT = new Font("Segoe UI", Font.PLAIN, 14);
    private static final Font BUTTON_FONT = new Font("Segoe UI", Font.BOLD, 14);

    private UIStyles() {
    }

    public static void stylePanelTree(Component component) {
        if (component instanceof JPanel panel) {
            panel.setOpaque(true);
            panel.setBackground(BG);
            if (panel.getBorder() instanceof TitledBorder titledBorder) {
                Border line = BorderFactory.createLineBorder(LINE, 1, true);
                Border empty = BorderFactory.createEmptyBorder(12, 12, 12, 12);
                panel.setBorder(BorderFactory.createCompoundBorder(line, empty));
                TitledBorder replacement = BorderFactory.createTitledBorder(
                    BorderFactory.createLineBorder(LINE, 1, true),
                    titledBorder.getTitle()
                );
                replacement.setTitleColor(ACCENT_DARK);
                replacement.setTitleFont(TITLE_FONT);
                panel.setBorder(BorderFactory.createCompoundBorder(replacement, empty));
                panel.setBackground(CARD);
            }
        }

        if (component instanceof JLabel label) {
            label.setForeground(INK);
            label.setFont(LABEL_FONT);
            label.setHorizontalAlignment(label.getHorizontalAlignment() == SwingConstants.CENTER
                ? SwingConstants.CENTER : SwingConstants.LEFT);
        }

        if (component instanceof JTextField field) {
            field.setFont(BODY_FONT);
            field.setForeground(INK);
            field.setBackground(Color.WHITE);
            field.setBorder(BorderFactory.createCompoundBorder(
                BorderFactory.createLineBorder(LINE, 1, true),
                BorderFactory.createEmptyBorder(8, 10, 8, 10)
            ));
        }

        if (component instanceof JComboBox<?> comboBox) {
            comboBox.setFont(BODY_FONT);
            comboBox.setForeground(INK);
            comboBox.setBackground(Color.WHITE);
        }

        if (component instanceof JButton button) {
            button.setFocusPainted(false);
            button.setFont(BUTTON_FONT);
            button.setForeground(Color.WHITE);
            button.setBackground(ACCENT);
            button.setBorder(BorderFactory.createCompoundBorder(
                BorderFactory.createLineBorder(ACCENT_DARK, 1, true),
                BorderFactory.createEmptyBorder(9, 16, 9, 16)
            ));
        }

        if (component instanceof JTable table) {
            table.setFont(BODY_FONT);
            table.setRowHeight(28);
            table.setGridColor(LINE);
            table.setSelectionBackground(new Color(219, 170, 135));
            table.setSelectionForeground(INK);
            table.setBackground(Color.WHITE);
            JTableHeader header = table.getTableHeader();
            header.setFont(LABEL_FONT);
            header.setBackground(HEADER);
            header.setForeground(INK);
        }

        if (component instanceof JScrollPane scrollPane) {
            scrollPane.getViewport().setBackground(Color.WHITE);
            scrollPane.setBorder(BorderFactory.createLineBorder(LINE, 1, true));
        }

        if (component instanceof JTabbedPane tabbedPane) {
            tabbedPane.setBackground(BG);
            tabbedPane.setForeground(INK);
            tabbedPane.setFont(LABEL_FONT);
        }

        if (component instanceof JComponent jComponent) {
            jComponent.setForeground(INK);
        }

        if (component instanceof Container container) {
            for (Component child : container.getComponents()) {
                stylePanelTree(child);
            }
        }
    }

    public static JLabel createHeroTitle(String text) {
        JLabel title = new JLabel(text, SwingConstants.CENTER);
        title.setFont(new Font("Georgia", Font.BOLD, 26));
        title.setForeground(INK);
        return title;
    }

    public static JLabel createHeroSubtitle(String text) {
        JLabel subtitle = new JLabel(text, SwingConstants.CENTER);
        subtitle.setFont(new Font("Segoe UI", Font.PLAIN, 14));
        subtitle.setForeground(MUTED);
        return subtitle;
    }

    public static String getErrorMessage(Throwable error) {
        Throwable current = error;
        while (current.getCause() != null) {
            current = current.getCause();
        }
        return current.getMessage() != null ? current.getMessage() : error.getMessage();
    }
}
