```sql
alter table booking add
    constraint fk_booking_product_id 
    foreign key (product_id) 
    references product (id)
```