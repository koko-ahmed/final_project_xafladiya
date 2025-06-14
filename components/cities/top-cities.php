<?php
$cities = [
    [
        'name' => 'Mogadishu',
        'image' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=800&auto=format&fit=crop&q=60'
    ],
    [
        'name' => 'Hargeisa',
        'image' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800&auto=format&fit=crop&q=60'
    ],
    [
        'name' => 'Garowe',
        'image' => 'https://images.unsplash.com/photo-1444723121867-7a241cacace9?w=800&auto=format&fit=crop&q=60'
    ],
    [
        'name' => 'Kismayo',
        'image' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=800&auto=format&fit=crop&q=60'
    ],
    [
        'name' => 'Baidoa',
        'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&auto=format&fit=crop&q=60'
    ],
    [
        'name' => 'Bosaso',
        'image' => 'https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?w=800&auto=format&fit=crop&q=60'
    ],
    [
        'name' => 'Beledweyne',
        'image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=800&auto=format&fit=crop&q=60'
    ],
    [
        'name' => 'Galkayo',
        'image' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=800&auto=format&fit=crop&q=60'
    ],
    [
        'name' => 'Dhusamareeb',
        'image' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800&auto=format&fit=crop&q=60'
    ],
    [
        'name' => 'Jowhar',
        'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&auto=format&fit=crop&q=60'
    ]
];
?>

<section class="top-cities-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">Top Cities in Somalia</h2>
        
        <div class="cities-container">
            <div class="row flex-nowrap overflow-auto pb-3" id="citiesRow">
                <?php foreach ($cities as $index => $city): ?>
                    <div class="col-9 col-sm-6 col-md-4 col-lg-3 mb-3 <?php echo $index >= 5 ? 'more-cities' : ''; ?>">
                        <div class="city-card h-100">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="<?php echo $city['image']; ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo $city['name']; ?>"
                                     loading="lazy">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0"><?php echo $city['name']; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-primary" id="toggleCities">
                <span class="show-more">See More Cities</span>
                <span class="show-less d-none">Show Less</span>
            </button>
        </div>
    </div>
</section>

<style>
.top-cities-section {
    background-color: #f8f9fa;
}

.cities-container {
    position: relative;
}

.cities-container::after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    width: 50px;
    background: linear-gradient(to right, transparent, #f8f9fa);
    pointer-events: none;
}

.city-card {
    transition: transform 0.3s ease;
}

.city-card:hover {
    transform: translateY(-5px);
}

.card {
    border-radius: 1rem;
    overflow: hidden;
}

.card-img-top {
    height: 200px;
    object-fit: cover;
}

.more-cities {
    display: none;
}

@media (min-width: 768px) {
    .cities-container::after {
        display: none;
    }
    
    .row {
        flex-wrap: wrap;
    }
    
    .col-md-4 {
        flex: 0 0 auto;
        width: 33.333333%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleCities');
    const moreCities = document.querySelectorAll('.more-cities');
    const showMoreText = toggleButton.querySelector('.show-more');
    const showLessText = toggleButton.querySelector('.show-less');
    
    // Check if JavaScript is enabled
    if (typeof toggleButton !== 'undefined') {
        // Hide the "See More" button if there are no additional cities
        if (moreCities.length === 0) {
            toggleButton.style.display = 'none';
        }
        
        toggleButton.addEventListener('click', function() {
            moreCities.forEach(city => {
                if (city.style.display === 'none' || !city.style.display) {
                    city.style.display = 'block';
                    showMoreText.classList.add('d-none');
                    showLessText.classList.remove('d-none');
                } else {
                    city.style.display = 'none';
                    showMoreText.classList.remove('d-none');
                    showLessText.classList.add('d-none');
                }
            });
        });
    } else {
        // If JavaScript is disabled, show all cities
        moreCities.forEach(city => {
            city.style.display = 'block';
        });
        toggleButton.style.display = 'none';
    }
});
</script> 