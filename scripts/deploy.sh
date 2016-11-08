echo "Zipping sources"
mkdir build
zip -r build/application.zip . -x *.git* build\*

echo "Deploy $TRAVIS_TAG version to S3"
aws s3 cp infra/handicap.cfn.yml s3://chatanoo-deployments-eu-west-1/infra/front/handicap/$TRAVIS_TAG.cfn.yml
aws s3 cp build/application.zip s3://chatanoo-deployments-eu-west-1/front/handicap/$TRAVIS_TAG.zip

echo "Upload latest"
aws s3api put-object \
  --bucket chatanoo-deployments-eu-west-1 \
  --key infra/front/handicap/latest.cfn.yml \
  --website-redirect-location /infra/front/handicap/$TRAVIS_TAG.cfn.yml
aws s3api put-object \
  --bucket chatanoo-deployments-eu-west-1 \
  --key front/handicap/latest.zip \
  --website-redirect-location /front/handicap/$TRAVIS_TAG.zip
