# Partsone バックエンド研修課題リポジトリ

## 概要
Yahooニュースのような、ユーザーが記事にアクセスし、コメントを行えるAPIを作成

## 仕様の詳細
1. 認証済みユーザーは記事を投稿可能
2. 認証済みユーザーは記事に対してコメントを作成可能
3. 全てのユーザーは記事を選択することで記事の内容とコメントを閲覧可能  
   a) 記事一覧は投稿日時によって新しい順にソート
4. 認証済みユーザーは自らが作成した記事とコメントを編集・削除可能

## 取り組んだ課題
以下の課題に取り組みました:

1. 認証とユーザー管理機能の実装
2. 記事投稿機能の実装（CRUD）
3. コメント機能の実装（CRUD）
4. APIのセキュリティ管理（認証トークンによるアクセス制御）

---

## アピールポイント・質問
あまり時間をかけられなかったので、特にアピールポイントはありません。
愚直に作ったことと、ちゃちゃっと終わらせられたことくらいです。

## コメント・補足
SwaggerUIを使うのが初めてで仕様書の書き方がわからなかったので、Swwagger-PHP(名前合ってるかな?)というライブラリを使ってOpenAPI仕様を自動生成する方法を取りました。
その過程で各コントローラーにアノテーションを書き込む必要がありました。
その影響でかなりのFatControllerができあがってしまいました。
最後に消そうと思いましたが、開発過程を説明するのにちょうどいいと思い残しています。
