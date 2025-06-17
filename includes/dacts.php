<?php
// DACTS framework logic

function evaluateConfluence($data) {
    $score = 0;

    // Trend evaluation
    if ($data['trend'] === 'bullish') {
        $score += 30;
    } elseif ($data['trend'] === 'bearish') {
        $score -= 30;
    }

    // Sentiment analysis
    if ($data['sentiment'] === 'positive') {
        $score += 20;
    } elseif ($data['sentiment'] === 'negative') {
        $score -= 20;
    }

    // Volume assessment
    if ($data['volume'] > 1000000) {
        $score += 50;
    } else {
        $score += 10;
    }

    // Pattern recognition confidence
    if (isset($data['pattern_confidence'])) {
        $score += $data['pattern_confidence'];
    }

    // Risk-reward ratio consideration
    if (isset($data['risk_reward_ratio'])) {
        if ($data['risk_reward_ratio'] >= 2) {
            $score += 20;
        } elseif ($data['risk_reward_ratio'] < 1) {
            $score -= 10;
        }
    }

    return [
        'confluence_score' => $score,
        'recommendation' => $score > 50 ? 'Strong Buy' : ($score < -50 ? 'Strong Sell': 'Neutral')
    ];
}
