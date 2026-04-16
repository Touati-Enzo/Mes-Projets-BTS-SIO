package ListReservations;

import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.PDPageContentStream;
import org.apache.pdfbox.pdmodel.common.PDRectangle;
import org.apache.pdfbox.pdmodel.font.PDFont;
import org.apache.pdfbox.pdmodel.font.PDType1Font;

import java.awt.Color;
import java.io.IOException;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.time.temporal.ChronoUnit;
import java.util.Locale;

public class ReservationPdfExporter {

    // ── Palette luxury ──────────────────────────────────────────────────────
    private static final Color NAVY      = new Color(0x0A, 0x0F, 0x1E);   // fond sombre
    private static final Color NAVY_MID  = new Color(0x0D, 0x15, 0x25);   // sections
    private static final Color GOLD      = new Color(0xC9, 0xA8, 0x4C);   // or principal
    private static final Color GOLD_LITE = new Color(0xE8, 0xC0, 0x6A);   // or clair
    private static final Color CREAM     = new Color(0xE8, 0xDF, 0xC8);   // texte clair
    private static final Color STEEL     = new Color(0xB8, 0xC8, 0xD8);   // texte secondaire
    private static final Color BORDER    = new Color(0x1E, 0x2D, 0x45);   // bordures

    private static final Color GREEN     = new Color(0x4C, 0xAF, 0x50);
    private static final Color RED_SOFT  = new Color(0xE8, 0x70, 0x70);
    private static final Color AMBER     = new Color(0xE8, 0xC0, 0x6A);

    private static final float A4_W = PDRectangle.A4.getWidth();   // 595
    private static final float A4_H = PDRectangle.A4.getHeight();  // 842

    public static void export(ReservationDetails r, String outputPath) throws IOException {
        try (PDDocument doc = new PDDocument()) {
            PDPage page = new PDPage(PDRectangle.A4);
            doc.addPage(page);

            PDFont fontSerif     = PDType1Font.TIMES_ROMAN;
            PDFont fontSerifBold = PDType1Font.TIMES_BOLD;
            PDFont fontSerifItal = PDType1Font.TIMES_ITALIC;
            PDFont fontMono      = PDType1Font.COURIER;

            try (PDPageContentStream cs = new PDPageContentStream(doc, page)) {

                // ── 1. Fond général ─────────────────────────────────────────
                fillRect(cs, 0, 0, A4_W, A4_H, NAVY);

                // ── 2. Bande header ─────────────────────────────────────────
                float headerH = 130;
                fillRect(cs, 0, A4_H - headerH, A4_W, headerH, new Color(0x06, 0x0B, 0x16));

                // Liseré or en bas du header
                fillRect(cs, 0, A4_H - headerH - 1, A4_W, 1.5f, GOLD);

                // Nom de l'hôtel
                drawTextCentered(cs, "Hôtel Prestige", fontSerifItal, 32, GOLD,
                        A4_W / 2f, A4_H - 58);

                // Sous-titre hôtel
                drawTextCentered(cs, "LUXURY COLLECTION  ·  MANAGEMENT SYSTEM", fontSerif, 8, STEEL,
                        A4_W / 2f, A4_H - 78);

                // Séparateur or miniature
                fillRect(cs, A4_W / 2f - 50, A4_H - 90, 100, 0.5f, GOLD);

                // Titre du document
                drawTextCentered(cs, "CONFIRMATION DE RÉSERVATION", fontSerifBold, 11, CREAM,
                        A4_W / 2f, A4_H - 112);

                // ── 3. Bandeau n° réservation ───────────────────────────────
                float badgeY = A4_H - headerH - 40;
                fillRoundRect(cs, 40, badgeY, A4_W - 80, 28, new Color(0x13, 0x1A, 0x0E));
                drawText(cs, "Réservation  N°", fontSerif, 9, STEEL, 55, badgeY + 10);
                drawText(cs, String.format("%06d", r.getId()), fontSerifBold, 13, GOLD_LITE, 155, badgeY + 9);

                // Date d'émission
                String today = LocalDate.now().format(DateTimeFormatter.ofPattern("dd MMMM yyyy",
                        java.util.Locale.FRENCH));
                drawTextRight(cs, "Émis le " + today, fontSerifItal, 8, STEEL, A4_W - 55, badgeY + 10);

                // ── 4. Statut badge ─────────────────────────────────────────
                float statusY = badgeY - 50;
                String statut = r.getStatut();
                Color statusColor, statusBg;
                String statusLabel;
                switch (statut) {
                    case "confirmee" -> { statusColor = GREEN;    statusBg = new Color(0x0F,0x2A,0x1A); statusLabel = "✓  CONFIRMÉE"; }
                    case "annulee"   -> { statusColor = RED_SOFT; statusBg = new Color(0x2A,0x0A,0x0A); statusLabel = "✕  ANNULÉE";  }
                    default          -> { statusColor = AMBER;    statusBg = new Color(0x2A,0x1E,0x08); statusLabel = "⏳  EN ATTENTE"; }
                }
                fillRoundRect(cs, 40, statusY, 160, 26, statusBg);
                drawText(cs, statusLabel, fontSerifBold, 10, statusColor, 56, statusY + 9);

                // ── 5. Bloc principal — deux colonnes ───────────────────────
                float sectionTop = statusY - 20;
                float colW = (A4_W - 80 - 16) / 2f;
                float col1X = 40;
                float col2X = 40 + colW + 16;

                // Colonne gauche : Séjour
                drawSectionCard(cs, col1X, sectionTop - 140, colW, 140,
                        "DÉTAILS DU SÉJOUR", fontSerifBold, fontSerif, fontSerifItal,
                        new String[][]{
                            {"Chambre",      r.getNumChambre()},
                            {"Arrivée",      formatDate(r.getDateDebut())},
                            {"Départ",       formatDate(r.getDateFin())},
                            {"Durée",        computeNights(r.getDateDebut(), r.getDateFin())},
                            {"Personnes",    String.valueOf(r.getNbPersonne())}
                        });

                // Colonne droite : Client & Tarif
                drawSectionCard(cs, col2X, sectionTop - 140, colW, 140,
                        "INFORMATIONS CLIENT & TARIF", fontSerifBold, fontSerif, fontSerifItal,
                        new String[][]{
                            {"ID Client",    String.valueOf(r.getUserId())},
                            {"Créée le",     formatDatetime(r.getCreatedAt())},
                            {"Prix total",   String.format("%.2f €", r.getPrix())},
                            {"Prix / nuit",  pricePerNight(r)},
                        });

                // ── 6. Encadré prix total ────────────────────────────────────
                float priceBoxY = sectionTop - 140 - 28;
                fillRect(cs, 40, priceBoxY, A4_W - 80, 50, NAVY_MID);
                fillRect(cs, 40, priceBoxY + 49, A4_W - 80, 1, BORDER);
                fillRect(cs, 40, priceBoxY, A4_W - 80, 1, BORDER);

                drawText(cs, "MONTANT TOTAL DU SÉJOUR", fontSerifBold, 8, STEEL, 55, priceBoxY + 34);
                drawText(cs, String.format("%.2f €", r.getPrix()), fontSerifBold, 24, GOLD, 55, priceBoxY + 14);

                String nights = computeNights(r.getDateDebut(), r.getDateFin());
                drawTextRight(cs, nights + " · Chambre " + r.getNumChambre(),
                        fontSerifItal, 9, STEEL, A4_W - 55, priceBoxY + 20);

                // ── 7. Note légale ───────────────────────────────────────────
                float noteY = priceBoxY - 30;
                fillRect(cs, 40, noteY, A4_W - 80, 0.5f, BORDER);
                drawTextCentered(cs,
                        "Ce document est généré automatiquement par le système de gestion Hôtel Prestige.",
                        fontSerifItal, 7, new Color(0x3D, 0x50, 0x68), A4_W / 2f, noteY - 12);

                // ── 8. Footer ────────────────────────────────────────────────
                fillRect(cs, 0, 0, A4_W, 40, new Color(0x06, 0x0B, 0x16));
                fillRect(cs, 0, 40, A4_W, 0.5f, GOLD);
                drawTextCentered(cs, "Hôtel Prestige  ·  Luxury Collection",
                        fontSerifItal, 9, GOLD, A4_W / 2f, 16);
            }

            doc.save(outputPath);
        }
    }

    // ── Helpers de dessin ────────────────────────────────────────────────────

    private static void fillRect(PDPageContentStream cs,
            float x, float y, float w, float h, Color c) throws IOException {
        cs.setNonStrokingColor(c);
        cs.addRect(x, y, w, h);
        cs.fill();
    }

    /** Simule un rect arrondi avec un simple rect légèrement indenté (PDFBox 2 n'a pas de roundRect natif) */
    private static void fillRoundRect(PDPageContentStream cs,
            float x, float y, float w, float h, Color c) throws IOException {
        fillRect(cs, x, y, w, h, c);          // fallback carré — suffisant pour badges
    }

    private static void drawText(PDPageContentStream cs, String text,
            PDFont font, float size, Color color, float x, float y) throws IOException {
        cs.beginText();
        cs.setFont(font, size);
        cs.setNonStrokingColor(color);
        cs.newLineAtOffset(x, y);
        cs.showText(safeText(text));
        cs.endText();
    }

    private static void drawTextCentered(PDPageContentStream cs, String text,
            PDFont font, float size, Color color, float cx, float y) throws IOException {
        float tw = font.getStringWidth(safeText(text)) / 1000f * size;
        drawText(cs, text, font, size, color, cx - tw / 2f, y);
    }

    private static void drawTextRight(PDPageContentStream cs, String text,
            PDFont font, float size, Color color, float rightX, float y) throws IOException {
        float tw = font.getStringWidth(safeText(text)) / 1000f * size;
        drawText(cs, text, font, size, color, rightX - tw, y);
    }

    private static void drawSectionCard(PDPageContentStream cs,
            float x, float y, float w, float h,
            String title,
            PDFont fontBold, PDFont fontNormal, PDFont fontItalic,
            String[][] rows) throws IOException {

        // Fond de la carte
        fillRect(cs, x, y, w, h, NAVY_MID);
        fillRect(cs, x, y + h - 1, w, 1, BORDER);
        fillRect(cs, x, y, w, 1, BORDER);
        fillRect(cs, x, y, 1, h, BORDER);
        fillRect(cs, x + w - 1, y, 1, h, BORDER);

        // Barre titre
        fillRect(cs, x, y + h - 26, w, 26, new Color(0x07, 0x0D, 0x1A));
        fillRect(cs, x, y + h - 27, w, 1, GOLD);
        drawText(cs, title, fontBold, 7, GOLD, x + 10, y + h - 17);

        // Lignes de données
        float rowH = (h - 30) / (float) rows.length;
        for (int i = 0; i < rows.length; i++) {
            float rowY = y + h - 30 - rowH * i - rowH / 2f - 4;
            drawText(cs, rows[i][0], fontItalic, 8, STEEL, x + 10, rowY);
            drawText(cs, rows[i][1], fontBold,   9, CREAM,  x + w / 2f, rowY);
            if (i < rows.length - 1)
                fillRect(cs, x + 1, rowY - 4, w - 2, 0.3f, BORDER);
        }
    }

    // ── Utilitaires ──────────────────────────────────────────────────────────

    private static String safeText(String s) {
        if (s == null) return "";
        // Supprime les caractères hors latin-1 sauf ceux supportés
        return s.replace("✓", "").replace("✕", "").replace("⏳", "")
                .replaceAll("[^\\x20-\\xFF]", "?");
    }

    private static String formatDate(String raw) {
        if (raw == null || raw.isBlank()) return "—";
        try {
            LocalDate d = LocalDate.parse(raw.substring(0, 10));
            return d.format(DateTimeFormatter.ofPattern("dd MMMM yyyy", java.util.Locale.FRENCH));
        } catch (Exception e) { return raw; }
    }

    private static String formatDatetime(String raw) {
        if (raw == null || raw.isBlank()) return "—";
        try {
            return raw.substring(0, 10);
        } catch (Exception e) { return raw; }
    }

    private static String computeNights(String debut, String fin) {
        try {
            LocalDate d1 = LocalDate.parse(debut.substring(0, 10));
            LocalDate d2 = LocalDate.parse(fin.substring(0, 10));
            long n = ChronoUnit.DAYS.between(d1, d2);
            return n + " nuit" + (n > 1 ? "s" : "");
        } catch (Exception e) { return "—"; }
    }

    private static String pricePerNight(ReservationDetails r) {
        try {
            LocalDate d1 = LocalDate.parse(r.getDateDebut().substring(0, 10));
            LocalDate d2 = LocalDate.parse(r.getDateFin().substring(0, 10));
            long n = ChronoUnit.DAYS.between(d1, d2);
            if (n <= 0) return "—";
            return String.format("%.2f € / nuit", r.getPrix() / n);
        } catch (Exception e) { return "—"; }
    }
}