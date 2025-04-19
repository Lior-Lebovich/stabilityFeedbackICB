# stabilityFeedbackICB


Overview
-------------------
This repository is associated with the paper "Idiosyncratic choice bias and feedback-induced bias differ in their long-term dynamics".

A well-known observation in repeated-choice experiments is that a tendency to prefer one response over the others emerges if the feedback consistently favors that response. However, choice bias, a tendency to prefer one response over the others, is not restricted to biased-feedback settings and is also observed when the feedback is unbiased. In fact, participant-specific choice bias, known as idiosyncratic choice bias (ICB), is common even in symmetrical experimental settings in which feedback is completely absent. Here we ask whether feedback-induced bias and ICB share a common mechanism. Specifically, we ask whether ICBs reflect idiosyncrasies in choice-feedback associations prior to the measurement of the ICB. To address this question, we compare the long-term dynamics of ICBs with feedback-induced biases. We show that while feedback effectively induced choice preferences, its effect is transient and diminished within several weeks. By contrast, we show that ICBs remained stable for at least 22 months. These results indicate that different mechanisms underlie the idiosyncratic and feedback-induced biases.

Data
-------------------
All data required to reproduce our results are available in the repository. 

Response data and inter-session delays are stored as sorted tables (`sortedTable_`) and assign tables (`assignTable_`), respectively, grouped by experiment ([`stability`](https://github.com/Lior-Lebovich/stabilityFeedbackICB/tree/main/stability) (study 1) and [`feedback`](https://github.com/Lior-Lebovich/stabilityFeedbackICB/tree/main/feedback) (study 2)) and delay condition. Files follow the structure: `stabilityFeedbackICB/[EXPERIMENT_NAME]/[TABLES_TYPE]/[TABLE_TYPE]_[EXPERIMENT_NAME]_[DELAY_NAME].csv`

Analysis
-------------------
The code required to reproduce all analyses and related figures is available in the [`stabilityFeedbackICB.mlx`](https://github.com/Lior-Lebovich/stabilityFeedbackICB/blob/main/stabilityFeedbackICB.mlx) MATLAB (R2023b) Live Editor file (also available as [`stabilityFeedbackICB.pdf`](https://github.com/Lior-Lebovich/stabilityFeedbackICB/blob/main/stabilityFeedbackICB.pdf)).

All figures are saved in the [`figures`](https://github.com/Lior-Lebovich/stabilityFeedbackICB/tree/main/figures) folder in MATLAB FIG format.

For Binomial tests, we use the myBinomTest custom function, reference: Matthew Nelson (2015). https://www.mathworks.com/matlabcentral/fileexchange/24813-mybinomtest-s-n-p-sided MATLAB Central File Exchange. Retrieved February 9, 2016.

Web-based experiment scripts
-------------------
The PHP-based web interfaces used to run the experiments are available in the [`web-interface`](https://github.com/Lior-Lebovich/stabilityFeedbackICB/tree/main/web-interface) folder, grouped by experiment ([`stability`](https://github.com/Lior-Lebovich/stabilityFeedbackICB/tree/main/web-interface/stability) (study 1) and [`feedback`](https://github.com/Lior-Lebovich/stabilityFeedbackICB/tree/main/web-interface/feedback) (study 2)). Each folder contains the required `.php` scripts, associated `.png` assets used for trial presentation and response recording, and a flow diagram summarizing session structure and database storage.

Cite
-------------------
If you use code from this repository, please cite it using the Zenodo DOI: 
<a href="https://doi.org/10.5281/zenodo.13388598"><img src="https://zenodo.org/badge/DOI/10.5281/zenodo.13388598.svg" alt="DOI"></a>

Contributors
-------------------
This code was authored by Lior Lebovich, 2024.
