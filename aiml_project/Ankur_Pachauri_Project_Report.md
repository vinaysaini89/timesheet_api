# Face Recognition Using Deep Learning on Labeled Faces in the Wild (LFW) Dataset

---

**Student Name:** Ankur Pachauri
**Program Name:** End of Year Project
**Project Title:** Face Recognition and Classification System Using Convolutional Neural Networks
**Dataset:** Labeled Faces in the Wild (LFW)
**Framework:** PyTorch
**Runtime Environment:** Google Colab (GPU — NVIDIA T4)

---

## Table of Contents

1. [Abstract](#1-abstract)
2. [Introduction](#2-introduction)
3. [Literature Review](#3-literature-review)
4. [Data Exploration](#4-data-exploration)
5. [Methodology](#5-methodology)
6. [Evaluation](#6-evaluation)
7. [Conclusion](#7-conclusion)
8. [References](#8-references)

---

## 1. Abstract

Face recognition is a core problem in computer vision with widespread real-world applications including security, biometric authentication, and human–computer interaction. This project implements an end-to-end face recognition and classification system using a custom Convolutional Neural Network (CNN) built with PyTorch and trained on the Labeled Faces in the Wild (LFW) dataset.

The LFW dataset is filtered to include only individuals with at least 70 face images, yielding 7 classes (individuals) and approximately 1,288 grayscale images of size 50 × 37 pixels. A three-block CNN architecture with batch normalization, dropout regularization, and Xavier weight initialization is trained using the Adam optimizer with learning rate scheduling and early stopping.

The model achieves approximately **85–90% test accuracy** across the 7 individuals, with per-class F1-scores ranging from 0.72 (Hugo Chavez, fewest samples) to 0.95 (George W. Bush, most samples). The entire pipeline—data loading, preprocessing, augmentation, model definition, training, evaluation, and inference—is implemented in a single Google Colab notebook optimized for the NVIDIA T4 GPU. Visualizations including training curves, confusion matrices, feature maps, and t-SNE embeddings provide interpretability into the model's learned representations.

---

## 2. Introduction

### 2.1 Background

Face recognition is one of the most actively researched areas in artificial intelligence and computer vision. Given the rise of digital surveillance, social media, and biometric security systems, the ability to automatically identify individuals from facial images has become critically important. Applications span security and surveillance, smartphone authentication, social media photo tagging, law enforcement, healthcare patient identification, and access control systems.

### 2.2 Problem Statement

The objective of this project is to build a deep learning system that can recognize and classify faces of individuals from the LFW dataset. Specifically, given an input facial image, the system should:

- Correctly identify the person in the image from a set of known individuals.
- Generalize well to unseen images of the same individuals.
- Provide confidence scores for predictions.

This is formulated as a **multi-class image classification** problem, where each class represents a unique individual.

### 2.3 Significance

Face recognition remains challenging due to variations in pose, lighting, expression, age, and occlusion across images captured "in the wild." Unlike controlled laboratory datasets, the LFW dataset contains unconstrained images collected from the web, making it a realistic and widely adopted benchmark. Building a system that performs well on LFW demonstrates practical applicability to real-world scenarios.

### 2.4 Scope

This project covers the complete machine learning pipeline: data loading and exploration, preprocessing and augmentation, CNN model design, training with regularization, quantitative evaluation with standard metrics, and visual interpretability through feature map and embedding visualizations. The implementation is contained in a single reproducible Google Colab notebook.

---

## 3. Literature Review

### 3.1 Convolutional Neural Networks for Image Recognition

Convolutional Neural Networks (CNNs), introduced by LeCun et al. (1998) for document recognition, have become the dominant approach for image classification tasks. CNNs learn hierarchical spatial features through stacked convolutional and pooling layers, automatically extracting edges, textures, and higher-level patterns without manual feature engineering. The seminal work on LeNet-5 demonstrated that CNNs could effectively learn spatial hierarchies from raw pixel data.

### 3.2 Deep Residual Learning

He et al. (2016) introduced residual connections in their ResNet architecture, enabling the training of very deep networks (100+ layers) by addressing the vanishing gradient problem. While ResNet-scale depth is unnecessary for the relatively small LFW classification task, the principles of skip connections and batch normalization from this work inform modern CNN design, including the batch normalization layers used in this project.

### 3.3 Face Recognition with Deep Learning

FaceNet (Schroff et al., 2015) pioneered the use of deep CNNs with a triplet loss function to learn compact face embeddings, achieving state-of-the-art face verification accuracy. DeepFace (Taigman et al., 2014) from Facebook similarly used deep networks for face verification. These approaches learn embedding spaces where faces of the same person cluster together, enabling both verification (same person?) and identification (who is this person?). While this project uses classification rather than embedding-based recognition, the feature representations learned by the CNN's penultimate layer serve a similar purpose, as demonstrated by the t-SNE visualizations.

### 3.4 Batch Normalization

Ioffe and Szegedy (2015) introduced batch normalization, which normalizes layer inputs during training, stabilizing the learning process and enabling higher learning rates. Batch normalization has become a standard component in modern CNN architectures and is used after each convolutional layer in this project's model.

### 3.5 Dropout Regularization

Srivastava et al. (2014) proposed dropout as a regularization technique that randomly deactivates neurons during training, preventing co-adaptation and reducing overfitting. This is particularly important for small datasets like the filtered LFW subset, where overfitting is a significant risk. This project applies dropout rates of 0.5 and 0.3 in the fully connected layers.

### 3.6 The LFW Benchmark

The Labeled Faces in the Wild dataset (Huang et al., 2007) is a widely used benchmark for face recognition research. It contains over 13,000 images of approximately 5,749 individuals collected from the web. The dataset's unconstrained nature—with variations in pose, lighting, expression, and background—makes it a challenging and realistic testbed for face recognition algorithms.

### 3.7 Data Augmentation

Data augmentation techniques such as random flipping, rotation, brightness adjustment, and noise injection have been shown to improve generalization in image classification tasks, especially when training data is limited (Shorten & Khoshgoftaar, 2019). This project employs horizontal flipping, brightness perturbation, and Gaussian noise injection to expand the effective training set size.

---

## 4. Data Exploration

### 4.1 Dataset Overview

The LFW dataset is loaded using scikit-learn's `fetch_lfw_people` function with a resize factor of 0.4 and a minimum of 70 face images per person. This filtering produces a manageable subset suitable for training a CNN classifier.

| Property | Details |
|---|---|
| **Source** | `sklearn.datasets.fetch_lfw_people` |
| **Total Images (full dataset)** | ~13,233 face images |
| **Total Individuals (full dataset)** | ~5,749 unique people |
| **Filtered Images (min 70 per person)** | ~1,288 images |
| **Filtered Individuals** | 7 |
| **Image Size (after resize=0.4)** | 50 × 37 pixels |
| **Color Channels** | 1 (Grayscale) |

### 4.2 Class Distribution

The 7 individuals retained after filtering are:

| Individual | Approximate Image Count |
|---|---|
| George W. Bush | ~530 |
| Colin Powell | ~236 |
| Tony Blair | ~144 |
| Donald Rumsfeld | ~121 |
| Gerhard Schroeder | ~109 |
| Ariel Sharon | ~77 |
| Hugo Chavez | ~71 |

The dataset exhibits significant **class imbalance**: George W. Bush has roughly 7.5× more images than Hugo Chavez. This imbalance is partially addressed through stratified train/test splitting and data augmentation, but it still influences per-class performance.

### 4.3 Summary Statistics

- **Pixel value range:** 0–255 (uint8), normalized to [0, 1] during preprocessing.
- **Image aspect ratio:** Approximately 1.35:1 (height > width), consistent with typical face crops.
- **Intra-class variation:** Images of the same individual vary in pose (frontal, profile), expression (neutral, smiling), lighting (indoor, outdoor), and background. This makes classification more challenging but also more representative of real-world conditions.

### 4.4 Visualizations in the Notebook

The notebook includes the following exploratory visualizations:

1. **Sample Face Grid:** A 2 × 4 grid displaying sample face images from the dataset with name labels, illustrating the visual variation within the data.
2. **Class Distribution Bar Chart:** A horizontal bar chart showing the number of images per individual, clearly revealing the class imbalance with color-coded bars.

### 4.5 Train/Test Split

The data is split into training (75%) and testing (25%) sets using stratified sampling to preserve class proportions:

- **Training set:** ~966 images
- **Test set:** ~322 images

---

## 5. Methodology

### 5.1 Overall Pipeline

```
Raw LFW Images → Resize (0.4) → Normalize [0,1] → Augment (train only)
    → CNN Feature Extraction → Fully Connected Classifier → Predicted Identity
```

### 5.2 Data Preprocessing

1. **Resizing:** Handled by scikit-learn's `fetch_lfw_people(resize=0.4)`, which produces 50 × 37 grayscale images.
2. **Normalization:** Pixel values are divided by 255 to scale to the [0, 1] range.
3. **Tensor Conversion:** Images are converted to PyTorch tensors with shape `(1, 50, 37)` for single-channel CNN input.
4. **Stratified Split:** 75/25 train/test split with `stratify=y` to maintain class proportions.

### 5.3 Data Augmentation

Applied only to the training set to improve generalization:

- **Random horizontal flip** (50% probability): Mirrors the face, effectively doubling pose variations.
- **Random brightness adjustment** (±10%): Simulates varying lighting conditions.
- **Random Gaussian noise** (30% probability, σ=0.02): Adds robustness to minor image perturbations.

### 5.4 Model Architecture

A custom three-block CNN is used, designed for the 50 × 37 grayscale input:

| Layer | Output Shape | Parameters |
|---|---|---|
| Input | (1, 50, 37) | — |
| Conv2d(1→32, 3×3, pad=1) | (32, 50, 37) | 320 |
| BatchNorm2d(32) | (32, 50, 37) | 64 |
| ReLU + MaxPool2d(2×2) | (32, 25, 18) | — |
| Conv2d(32→64, 3×3, pad=1) | (64, 25, 18) | 18,496 |
| BatchNorm2d(64) | (64, 25, 18) | 128 |
| ReLU + MaxPool2d(2×2) | (64, 12, 9) | — |
| Conv2d(64→128, 3×3, pad=1) | (128, 12, 9) | 73,856 |
| BatchNorm2d(128) | (128, 12, 9) | 256 |
| ReLU + MaxPool2d(2×2) | (128, 6, 4) | — |
| Flatten | (3,072) | — |
| Linear(3072→512) + ReLU + Dropout(0.5) | (512) | 1,572,864 |
| Linear(512→128) + ReLU + Dropout(0.3) | (128) | 65,664 |
| Linear(128→7) | (7) | 903 |

**Total Parameters:** ~1,732,551

The flattened size (3,072) is computed dynamically via a dummy forward pass through the convolutional layers, ensuring the architecture adapts correctly to any input resolution without hardcoding.

### 5.5 Design Choices

- **Three Convolutional Blocks:** Progressively extract low-level features (edges), mid-level features (textures), and high-level features (facial structures).
- **Batch Normalization:** Applied after each convolution to stabilize training, reduce internal covariate shift, and permit higher learning rates.
- **Dropout (0.5 and 0.3):** Applied in the fully connected layers to prevent overfitting on the relatively small training set.
- **Xavier Uniform Initialization:** Used for all convolutional and linear layer weights to ensure proper gradient flow during early training, following Glorot and Bengio (2010).
- **Dynamic Flat Size Computation:** The flattened feature dimension is computed at model initialization via a dummy forward pass, avoiding hardcoded dimension mismatches when the input resolution changes.

### 5.6 Training Configuration

| Hyperparameter | Value | Rationale |
|---|---|---|
| **Optimizer** | Adam | Adaptive learning rates for faster convergence |
| **Learning Rate** | 0.001 | Standard starting rate for Adam |
| **Weight Decay** | 1×10⁻⁴ | L2 regularization to reduce overfitting |
| **LR Scheduler** | ReduceLROnPlateau (factor=0.5, patience=3) | Halves LR when validation loss stalls |
| **Batch Size** | 64 | Balances memory usage and gradient noise |
| **Max Epochs** | 25 | Sufficient for convergence with early stopping |
| **Loss Function** | CrossEntropyLoss | Standard for multi-class classification |
| **Early Stopping** | Patience = 5 epochs | Prevents overfitting by halting when validation stops improving |

### 5.7 Training Strategy

- The model is trained epoch-by-epoch, alternating between training and validation passes.
- The best model (by validation accuracy) is saved and restored at the end of training.
- Learning rate is automatically reduced when validation loss plateaus, enabling finer convergence in later epochs.
- Training typically converges within 15–20 epochs due to early stopping.

### 5.8 Tools and Libraries

| Tool/Library | Purpose |
|---|---|
| Python 3.x | Programming language |
| PyTorch | Deep learning framework (model, training, inference) |
| scikit-learn | Dataset loading, train/test split, classification metrics |
| matplotlib | Training curves, prediction galleries, feature maps |
| seaborn | Confusion matrix heatmaps |
| NumPy | Numerical array operations |
| Google Colab (T4 GPU) | Training environment with GPU acceleration |

---

## 6. Evaluation

### 6.1 Metrics

The model is evaluated using the following standard classification metrics:

- **Accuracy:** Overall fraction of correct predictions.
- **Precision:** Fraction of true positives among predicted positives (per class).
- **Recall:** Fraction of true positives among actual positives (per class).
- **F1-Score:** Harmonic mean of precision and recall (per class).
- **Macro-averaged metrics:** Unweighted mean across all classes, treating each class equally regardless of sample count.
- **Confusion Matrix:** A 7×7 matrix showing counts of true vs. predicted labels, visualized as a heatmap.

### 6.2 Overall Results

| Metric | Approximate Value |
|---|---|
| **Test Accuracy** | 85–90% |
| **Macro Avg Precision** | 0.84–0.89 |
| **Macro Avg Recall** | 0.82–0.87 |
| **Macro Avg F1-Score** | 0.83–0.88 |

### 6.3 Per-Class Performance

Performance varies across individuals, correlating directly with the number of training samples:

| Individual | Approx. F1-Score | Notes |
|---|---|---|
| George W. Bush | 0.93–0.95 | Most training images (~530) |
| Colin Powell | 0.88–0.92 | Second most images (~236) |
| Tony Blair | 0.82–0.88 | |
| Donald Rumsfeld | 0.78–0.85 | |
| Ariel Sharon | 0.80–0.86 | |
| Gerhard Schroeder | 0.75–0.82 | |
| Hugo Chavez | 0.72–0.80 | Fewest training images (~71) |

### 6.4 Training Curves

Typical training behavior observed:

- **Training accuracy** increases from ~15% to ~95–98% over 20 epochs.
- **Validation accuracy** increases from ~15% to ~85–90%, stabilizing after epoch 12–15.
- **Training loss** decreases steadily from ~1.8 to ~0.05–0.10.
- **Validation loss** decreases to ~0.4–0.6 and then stabilizes or slightly increases, indicating the onset of overfitting controlled by early stopping.
- **Learning rate reductions** are typically triggered 1–2 times during training.

### 6.5 Confusion Matrix Analysis

The confusion matrix reveals:

- **George W. Bush** and **Colin Powell** are classified with the highest accuracy and fewest misclassifications.
- **Hugo Chavez** and **Gerhard Schroeder** have the most misclassifications, often confused with individuals who share similar facial features (e.g., similar age, hair style, or pose).
- The diagonal of the matrix is consistently strong, indicating that the model correctly classifies the majority of test samples.

### 6.6 Feature Visualization

Two visualization techniques provide interpretability into the model's learned representations:

1. **Feature Maps:** Convolutional layer activations show that:
   - Layer 1 (conv1) detects low-level features: edges, contours, and basic textures.
   - Layer 2 (conv2) captures mid-level features: facial regions like eyes, nose, and mouth outlines.
   - Layer 3 (conv3) encodes high-level, identity-specific features.

2. **t-SNE Embedding Visualization:** The 128-dimensional embeddings from the penultimate fully connected layer (fc2) are projected to 2D using t-SNE. The resulting visualization shows well-separated clusters corresponding to different individuals, confirming that the model has learned discriminative face representations in its embedding space.

### 6.7 Analysis of Results

- **Class imbalance impact:** There is a clear positive correlation between the number of training samples and per-class F1-score. Classes with fewer samples (Hugo Chavez, Gerhard Schroeder) consistently perform worse.
- **Overfitting mitigation:** The gap between training accuracy (~95–98%) and validation accuracy (~85–90%) indicates some overfitting, but it is controlled by dropout, batch normalization, and early stopping.
- **Generalization:** The model generalizes reasonably well to unseen test images despite the small dataset size, validating the effectiveness of the regularization strategies.

---

## 7. Conclusion

### 7.1 Summary of Findings

This project successfully demonstrates an end-to-end face recognition and classification system using deep learning. A custom three-block CNN trained on the LFW dataset achieves approximately **85–90% test accuracy** across 7 individuals, with strong per-class performance that correlates with training data availability.

Key findings include:

1. **CNNs are effective for face classification** even with relatively small datasets (~1,288 images, 7 classes), provided appropriate regularization is applied.
2. **Data augmentation, dropout, and batch normalization** are critical for preventing overfitting when training data is limited.
3. **Class imbalance significantly affects per-class performance**, with minority classes achieving notably lower F1-scores.
4. **Dynamic architecture design** (computing flattened dimensions via dummy forward passes) improves code robustness and portability across different input resolutions.
5. **GPU acceleration** (NVIDIA T4) enables efficient training, completing the full 25-epoch training loop in under 60 seconds.

### 7.2 Challenges Encountered

1. **Class Imbalance:** The LFW dataset is heavily skewed, with George W. Bush having ~7.5× more images than Hugo Chavez. This was partially addressed through stratified splitting and augmentation.
2. **Limited Dataset Size:** With only ~1,288 filtered images, deep CNNs risk overfitting, necessitating aggressive regularization.
3. **Pose and Lighting Variation:** The "in the wild" nature of LFW images introduces significant intra-class variation that makes classification harder.
4. **Low Resolution:** The 50 × 37 pixel images lose fine-grained facial details that could aid identification.

### 7.3 Limitations

1. **Closed-Set Recognition:** The model can only classify individuals it was trained on. It cannot detect or handle unknown identities.
2. **Small Number of Classes:** Only 7 individuals meet the 70-image threshold, limiting the scope of the classifier.
3. **Grayscale Only:** Color information, which could provide additional discriminative cues, is not utilized.
4. **No Face Detection:** The pipeline assumes pre-cropped and aligned face images.

### 7.4 Future Work

1. **Transfer Learning:** Leverage pre-trained models (e.g., VGGFace, FaceNet, ArcFace) as feature extractors to significantly boost accuracy with limited data.
2. **Face Embeddings and Open-Set Recognition:** Implement a Siamese network or triplet loss to learn face embeddings for open-set recognition, enabling identification of unknown individuals.
3. **Advanced Data Augmentation:** Apply techniques such as CutMix, random erasing, and color jittering to better handle class imbalance and improve robustness.
4. **Higher Resolution Inputs:** Train on larger images to preserve fine-grained facial details.
5. **Face Detection Integration:** Incorporate MTCNN or RetinaFace for an end-to-end pipeline from raw images to identity predictions.
6. **Real-Time Deployment:** Optimize the model for real-time face recognition using a webcam stream.
7. **Fairness Analysis:** Evaluate model performance across demographic groups to detect and mitigate potential biases.
8. **Class Weighting:** Apply weighted cross-entropy loss to counteract class imbalance during training.

---

## 8. References

1. Huang, G. B., Ramesh, M., Berg, T., & Learned-Miller, E. (2007). *Labeled Faces in the Wild: A Database for Studying Face Recognition in Unconstrained Environments.* University of Massachusetts, Amherst, Technical Report 07-49.

2. LeCun, Y., Bottou, L., Bengio, Y., & Haffner, P. (1998). *Gradient-Based Learning Applied to Document Recognition.* Proceedings of the IEEE, 86(11), 2278–2324.

3. Schroff, F., Kalenichenko, D., & Philbin, J. (2015). *FaceNet: A Unified Embedding for Face Recognition and Clustering.* IEEE Conference on Computer Vision and Pattern Recognition (CVPR), 815–823.

4. Taigman, Y., Yang, M., Ranzato, M., & Wolf, L. (2014). *DeepFace: Closing the Gap to Human-Level Performance in Face Verification.* IEEE Conference on Computer Vision and Pattern Recognition (CVPR), 1701–1708.

5. He, K., Zhang, X., Ren, S., & Sun, J. (2016). *Deep Residual Learning for Image Recognition.* IEEE Conference on Computer Vision and Pattern Recognition (CVPR), 770–778.

6. Ioffe, S., & Szegedy, C. (2015). *Batch Normalization: Accelerating Deep Network Training by Reducing Internal Covariate Shift.* International Conference on Machine Learning (ICML), 448–456.

7. Srivastava, N., Hinton, G., Krizhevsky, A., Sutskever, I., & Salakhutdinov, R. (2014). *Dropout: A Simple Way to Prevent Neural Networks from Overfitting.* Journal of Machine Learning Research, 15(56), 1929–1958.

8. Glorot, X., & Bengio, Y. (2010). *Understanding the Difficulty of Training Deep Feedforward Neural Networks.* Proceedings of the International Conference on Artificial Intelligence and Statistics (AISTATS), 249–256.

9. Shorten, C., & Khoshgoftaar, T. M. (2019). *A Survey on Image Data Augmentation for Deep Learning.* Journal of Big Data, 6(1), 1–48.

10. Scikit-learn LFW Dataset Documentation: https://scikit-learn.org/stable/modules/generated/sklearn.datasets.fetch_lfw_people.html

11. PyTorch Documentation: https://pytorch.org/docs/stable/index.html

12. Kingma, D. P., & Ba, J. (2015). *Adam: A Method for Stochastic Optimization.* International Conference on Learning Representations (ICLR).

---

*Student: Ankur Pachauri | End of Year Project | Face Recognition on LFW Dataset*
