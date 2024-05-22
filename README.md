## 始め方

```sh
# リポジトリをclone
git clone https://github.com/koukibuu3/laravel-sample-project.git

# 初期スクリプトを実行
composer provision

# コンテナを立ち上げる
docker-compose up -d # もしくは ./vendor/bin/sail up -d

# テーブルを作成する
docker-compose exec laravel.test composer migrate
```
