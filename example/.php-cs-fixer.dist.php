<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude([
        'vendor',
        'bootstrap/cache',
        'storage',
    ]);

return new PhpCsFixer\Config()
    ->setRiskyAllowed(true)
    ->setRules([
        // --- 業界標準の最新セット ---
        '@PER-CS2.0' => true,
        '@PER-CS2.0:risky' => true,

        // --- PHPバージョンに合わせた最適化 ---
        '@PHP84Migration' => true,

        // --- 個別調整（一般的に好まれる追加ルール） ---
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha', 'imports_order' => ['const', 'class', 'function']],
        'no_unused_imports' => true,

        // --- 現場判断でOFFにすることが多いRiskyルール ---
        'strict_comparison' => false, // 挙動変化のリスクを避けるならfalse
        'strict_param' => false,      // 同上
    ])
    ->setFinder($finder);
