<?php
$stats = [
    [
        'number' => '34',
        'label' => '屆',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>'
    ],
    [
        'number' => '18',
        'label' => '國家',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>'
    ],
    // [
    //     'number' => '5',
    //     'label' => 'Năm kinh nghiệm',
    //     'icon' => 'fa-award'
    // ],
    [
        'number' => '778',
        'label' => '理監事',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>'
    ]
];
?>
<!-- phan noi dung of trang index --------------------------------------- -->
<!--LAY THONG TIN SU KIEN QUAN TRONG-->
    <!-- Hero Stats Panel -->
    <div id="hero-stats" class="container hero-stats reveal">
        <div class="stats-grid">
            <?php foreach ($stats as $st): ?>
                <div class="stat-card">
                    <div class="stat-icon"><?php echo $st['icon']; ?></div>
                    <div class="stat-info">
                        <h3><?php echo $st['number']; ?></h3>
                        <p><?php echo $st['label']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>