# Tubes TST Kelompok 16 - Delivery

## How to run

1. Run composer install
2. Copy .env.example, rename it and set it up with your environment preferences
3. Run `php spark migrate --all`. The `-all` option is important
4. Run `php spark serve`

## Notes
* In your environment settings, you need to set `api_delivery_email` and `api_delivery_password` fields with the account credentials you created in the delivery service app. You need to use an account with AT LEAST having default role
* You don't have to set the token in `api_delivery_token` field. The system will set it automatically if you input credentials properly


## Troubleshooting

* For remigrating, USE `--all` option, this is important
