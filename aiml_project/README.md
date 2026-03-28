# AIML End of Program Project

**Student:** Ankur Pachauri  
**Project:** End of Program Project — Chatbots for Customer Support  
**Course:** Artificial Intelligence & Machine Learning (AIML)

---

## Contents

| File | Description |
|------|-------------|
| `Ankur_Pachauri_Chatbot_Colab.ipynb` | Google Colab notebook with full implementation |
| `generate_report.py` | Python script that generates the PDF report |
| `Ankur_Pachauri_Chatbot_Report.pdf` | Generated PDF report (after running the script) |

---

## Quick Start

### 1 — Run the Colab notebook

1. Open [Google Colab](https://colab.research.google.com/).
2. Upload `Ankur_Pachauri_Chatbot_Colab.ipynb`.
3. Switch runtime to **GPU** (Runtime → Change runtime type → T4 GPU).
4. Run all cells top-to-bottom (**Runtime → Run all**).

The notebook will:
- Download the Cornell Movie Dialogs Corpus automatically.
- Preprocess and build the vocabulary.
- Train a Seq2Seq model with Bahdanau attention.
- Evaluate using BLEU scores and perplexity.
- Show an interactive chatbot demo.

### 2 — Generate the PDF Report

```bash
pip install fpdf2
python generate_report.py
```

This produces `Ankur_Pachauri_Chatbot_Report.pdf` in the same directory.

---

## Architecture Summary

```
Input sentence
      │
  ┌───▼────────────────────────────┐
  │  Encoder (Bidirectional GRU)   │
  │  embedding(128) → GRU(256×2)  │
  └───────────────────┬────────────┘
                      │ encoder outputs (B, T, 512)
  ┌───────────────────▼────────────┐
  │   Bahdanau Attention           │
  │   score = vᵀ tanh(W1·h + W2·s)│
  │   α = softmax(score)           │
  │   context = Σ αᵢ hᵢ            │
  └───────────────────┬────────────┘
                      │ context vector (B, 512)
  ┌───────────────────▼────────────┐
  │  Decoder (Unidirectional GRU)  │
  │  [emb(t); context] → GRU(256) │
  │  → Linear → Vocabulary logits │
  └────────────────────────────────┘
```

---

## Dependencies

| Package | Version |
|---------|---------|
| Python  | ≥ 3.8   |
| PyTorch | ≥ 2.0   |
| NLTK    | ≥ 3.8   |
| Matplotlib | ≥ 3.7 |
| Seaborn | ≥ 0.12  |
| fpdf2   | ≥ 2.7 *(report only)* |

---

## Report Sections

1. Abstract
2. Introduction
3. Literature Review
4. Data Exploration
5. Methodology
6. Evaluation
7. Conclusion
8. References

Footer on every page: *Ankur Pachauri | End of Program Project*
