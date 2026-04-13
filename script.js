
// 12 Sıra x 4 Koltuk = 48 Koltukluk Uçak 
const seatData = [
    // 1. SIRA
    { id: '1A', type: 'Cam', price: 1500, score: 2.3, comment: 'Sakin ama motor sesi çok.', occupied: false },
    { id: '1B', type: 'Koridor', price: 1000, score: null, comment: '', occupied: true }, 
    { id: '1C', type: 'Koridor', price: 1000, score: 3.1, comment: 'Ortalama.', occupied: false },
    { id: '1D', type: 'Cam', price: 1500, score: 4.4, comment: 'Geniş diz mesafesi.', occupied: false },

    // 2. SIRA
    { id: '2A', type: 'Cam', price: 1500, score: 4.3, comment: 'Çok güzel manzara.', occupied: false },
    { id: '2B', type: 'Koridor', price: 1000, score: null, comment: '', occupied: true },
    { id: '2C', type: 'Koridor', price: 1000, score: 4.1, comment: 'Temiz.', occupied: false },
    { id: '2D', type: 'Cam', price: 1500, score: 3.9, comment: 'Biraz dar.', occupied: false },

    // 3. SIRA
    { id: '3A', type: 'Cam', price: 1500, score: 1.7, comment: 'Koltuk bozuktu.', occupied: false },
    { id: '3B', type: 'Koridor', price: 1000, score: 4.5, comment: 'Mükemmel hizmet.', occupied: false },
    { id: '3C', type: 'Koridor', price: 1000, score: 3.3, comment: 'Eh işte.', occupied: false },
    { id: '3D', type: 'Cam', price: 1500, score: 3.5, comment: 'Geniş.', occupied: false },
    
    // 4. SIRA
    { id: '4A', type: 'Cam', price: 1500, score: 4.1, comment: 'Konforlu.', occupied: false },
    { id: '4B', type: 'Koridor', price: 1000, score: null, comment: '', occupied: true },
    { id: '4C', type: 'Koridor', price: 1000, score: 3.3, comment: 'Geniş koridor.', occupied: false },
    { id: '4D', type: 'Cam', price: 1500, score: 4.6, comment: 'Koridor tarafı her zaman iyidir.', occupied: false },

    // 5. SIRA
    { id: '5A', type: 'Cam', price: 1400, score: null, comment: '', occupied: true },
    { id: '5B', type: 'Koridor', price: 900, score: 4.0, comment: 'Uyumak için ideal.', occupied: false },
    { id: '5C', type: 'Koridor', price: 900, score: null, comment: '', occupied: true },
    { id: '5D', type: 'Cam', price: 1400, score: 3.8, comment: 'Kanat manzarası güzel.', occupied: false },

    // 6. SIRA (Kanat Üstü - Genelde Sesli Olur)
    { id: '6A', type: 'Cam', price: 1200, score: 2.5, comment: 'Kanat yüzünden dışarısı görünmüyor.', occupied: false },
    { id: '6B', type: 'Koridor', price: 800, score: 3.0, comment: 'Biraz gürültülü.', occupied: false },
    { id: '6C', type: 'Koridor', price: 800, score: null, comment: '', occupied: true },
    { id: '6D', type: 'Cam', price: 1200, score: 2.8, comment: 'Motor sesi rahatsız edici.', occupied: false },

    // 7. SIRA
    { id: '7A', type: 'Cam', price: 1400, score: 4.2, comment: 'Rahat bir uçuştu.', occupied: false },
    { id: '7B', type: 'Koridor', price: 900, score: null, comment: '', occupied: true },
    { id: '7C', type: 'Koridor', price: 900, score: 3.9, comment: 'İkramlar güzeldi.', occupied: false },
    { id: '7D', type: 'Cam', price: 1400, score: null, comment: '', occupied: true },

    // 8. SIRA
    { id: '8A', type: 'Cam', price: 1400, score: null, comment: '', occupied: true },
    { id: '8B', type: 'Koridor', price: 900, score: null, comment: '', occupied: true },
    { id: '8C', type: 'Koridor', price: 900, score: 4.5, comment: 'Sorunsuz.', occupied: false },
    { id: '8D', type: 'Cam', price: 1400, score: 4.7, comment: 'Güneş batışı efsaneydi.', occupied: false },

    // 9. SIRA (Acil Çıkış - Geniş Diz Mesafesi)
    { id: '9A', type: 'Cam', price: 2000, score: 5.0, comment: 'Acil çıkış, bacak bacak üstüne attım!', occupied: false },
    { id: '9B', type: 'Koridor', price: 1500, score: null, comment: '', occupied: true },
    { id: '9C', type: 'Koridor', price: 1500, score: 4.8, comment: 'Dizlerim bayram etti.', occupied: false },
    { id: '9D', type: 'Cam', price: 2000, score: null, comment: '', occupied: true },

    // 10. SIRA
    { id: '10A', type: 'Cam', price: 1300, score: 3.5, comment: 'Normal koltuk.', occupied: false },
    { id: '10B', type: 'Koridor', price: 850, score: 3.2, comment: 'Hostesler çok geziyor.', occupied: false },
    { id: '10C', type: 'Koridor', price: 850, score: null, comment: '', occupied: true },
    { id: '10D', type: 'Cam', price: 1300, score: 3.8, comment: 'Sakin.', occupied: false },

    // 11. SIRA
    { id: '11A', type: 'Cam', price: 1300, score: null, comment: '', occupied: true },
    { id: '11B', type: 'Koridor', price: 850, score: null, comment: '', occupied: true },
    { id: '11C', type: 'Koridor', price: 850, score: 3.6, comment: 'Fena değil.', occupied: false },
    { id: '11D', type: 'Cam', price: 1300, score: null, comment: '', occupied: true },

    // 12. SIRA (Arka Sıra - Tuvalete Yakın)
    { id: '12A', type: 'Cam', price: 1100, score: 2.1, comment: 'Tuvalet kokusu geliyordu.', occupied: false },
    { id: '12B', type: 'Koridor', price: 750, score: 2.4, comment: 'Sıra bekleyenler başımda dikildi.', occupied: false },
    { id: '12C', type: 'Koridor', price: 750, score: null, comment: '', occupied: true },
    { id: '12D', type: 'Cam', price: 1100, score: 2.0, comment: 'Koltuk arkaya yatmıyordu.', occupied: false }
];

// --- ANA FONKSİYONLAR ---

const seatingPlanEl = document.getElementById('seatingPlan');
const bookingSummaryEl = document.getElementById('bookingSummary');
let currentSelectedSeat = null;

// 1. Kabin Tasarımını Oluşturma
function initSeatingChart() {
    seatData.forEach((seat, index) => {
        // Koridor boşluğu kodu
        if (index > 0 && index % 4 === 2) {
            const corridor = document.createElement('div');
            corridor.style.width = "40px";
            seatingPlanEl.appendChild(corridor);
        }

        const seatEl = document.createElement('div');
        seatEl.classList.add('seat');
        seatEl.dataset.id = seat.id;
        
        // --- YENİ: Düşük puanlı koltuk kontrolü ---
        if (seat.score !== null && seat.score < 3 && !seat.occupied) {
            seatEl.classList.add('low-rated'); // CSS'deki rengi buraya çakar
        }
        // ------------------------------------------

        // Hover yapınca bilgi veren kutucuk
        seatEl.title = `${seat.type} - ${seat.price} TL - ${seat.score || 0} Yıldız`;

        const numSpan = document.createElement('span');
        numSpan.classList.add('seat-number');
        numSpan.textContent = seat.id;
        
        const scoreSpan = document.createElement('span');
        scoreSpan.classList.add('seat-score');
        scoreSpan.innerHTML = seat.score !== null ? `${seat.score} ⭐` : '&nbsp;';

        seatEl.appendChild(numSpan);
        seatEl.appendChild(scoreSpan);

        if (seat.occupied) {
            seatEl.classList.add('occupied');
        } else {
            seatEl.classList.add('empty');
            
            // TIKLAMA VE BUTON ÇIKARMA KODU
            seatEl.addEventListener('click', () => {
                handleSeatSelection(seatEl, seat);
                document.getElementById('satinAlBtn').style.display = 'block';
            });
        }

        seatingPlanEl.appendChild(seatEl);
    });
}

// 2. Renklendirme & Tıklama Mantığı
function handleSeatSelection(seatEl, seat) {
    if (seatEl.classList.contains('selected')) {
        seatEl.classList.remove('selected');
        seatEl.classList.add('empty');
        clearSummary();
        currentSelectedSeat = null;
        
        // Koltuk iptal edilirse butonu geri gizle
        document.getElementById('satinAlBtn').style.display = 'none';
        return;
    }

    if (currentSelectedSeat) {
        currentSelectedSeat.classList.remove('selected');
        currentSelectedSeat.classList.add('empty');
    }

    seatEl.classList.remove('empty');
    seatEl.classList.add('selected');
    currentSelectedSeat = seatEl;

    updateSummary(seat);
}

// 3. Özellik Gösterimi 
function updateSummary(seat) {
    const starScore = seat.score ? `${seat.score} / 5.0 ⭐` : 'Puanlanmamış';
    const commentHtml = seat.comment ? `"${seat.comment}"` : 'Henüz yorum yok.';
    
    bookingSummaryEl.innerHTML = `
        <div class="summary-card">
            <h3>Koltuk ${seat.id}</h3>
            <p><strong>Tür:</strong> ${seat.type}</p>
            <p><strong>Fiyat:</strong> ${seat.price} TL</p>
            <p><strong>Yolcu Puanı:</strong> ${starScore}</p>
            <p><strong>Son Yorum:</strong> <em>${commentHtml}</em></p>
        </div>
    `;
}

function clearSummary() {
    bookingSummaryEl.innerHTML = `<p>Henüz bir koltuk seçmediniz.</p>`;
}

// 4. Satın Al Butonunu Çalıştırma
document.getElementById('satinAlBtn').addEventListener('click', () => {
    const seciliKoltuk = document.querySelector('.seat.selected .seat-number').textContent;
    
    // Kullanıcıyı koltuk bilgisini URL'ye ekleyerek odeme.php'ye yolla
    window.location.href = `odeme.php?koltuk=${seciliKoltuk}`;
});
// Sayfa yüklendiğinde koltukları çiz
initSeatingChart();