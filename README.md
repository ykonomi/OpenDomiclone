# Domiclone

## 概要
ドミニオンのクローンゲーでオンラインでできるようにしたゲーム。  
ブラウザでの起動を想定しています。  

## 起動方法
ローカル起動用に build_local.sh を用意しています。 git clone後実行ください。  
ただし, ローカル環境では sqliteを使用しており、データベースファイルを絶対パスで指定する必要があります。  
.env.example の以下の項目を書き換えてください。

```
DB_DATABASE=/absolute/path/to/database.sqlite
```


## 画面
<img width="605" alt="2017-11-12 23 40 21" src="https://user-images.githubusercontent.com/29176287/32700112-b1fbc6a4-c803-11e7-8b7f-ea42f1e3454e.png">
<img width="683" alt="2017-11-20 1 02 46" src="https://user-images.githubusercontent.com/29176287/32992480-8e21da44-cd8e-11e7-81dd-3df875e05c1b.png">


