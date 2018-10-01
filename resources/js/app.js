
require('./bootstrap');

$( document ).ready(function() {    
    
    $("table").stupidtable();       
    
    window.Echo.channel('crypto-update')
         .listen('TickerUpdated', data => {             
          
                var coin_id,avg_price,change24,cell_avg_price,cell_change24h;
                
                $.each(data.crypto, function (index) { 
                    
                    coin_id   = data.crypto[index]['coin_id'];
                    avg_price = data.crypto[index]['avg_price'];
                    change24  = data.crypto[index]['Change(24h)'];
                    
                    cell_avg_price = $('#crypto').find('.table_row[id="' + coin_id + '"] > .avg-price');
                    cell_change24h = $('#crypto').find('.table_row[id="' + coin_id + '"] > .change24h');                  
                                      
                    cell_avg_price.css('color',matchPrice( parseFloat(cell_avg_price.text()), parseFloat( avg_price ) )); 
                    cell_change24h.css('color',matchPrice( parseFloat(cell_change24h.text()), parseFloat( change24 ) ));                   
                                        
                    cell_avg_price.text(parseFloat(avg_price));
                    cell_change24h.text(parseFloat(change24)+"%");
                    
                });      
            
    });

    function matchPrice(currentPrice, newPrice) {

        var color;

        if (currentPrice < newPrice) {

            color = 'green';
        } else if (currentPrice > newPrice) {

            color = 'red';
        } else {

            color = 'black';
        }

        return color;
    }  
  
  
    $('#searchInput').keyup(function (event) {

        var value = $(this).val().toLowerCase();

        $("#crypto tr.table_row").filter(function () {

            $(this).toggle($(this).find('.name').text().toLowerCase().indexOf(value) > -1);

        });

    });
    $('#searchInput').focus(function () {
        if (this.value === 'Type To Filter') {
            this.value = '';
        }
    });


});
